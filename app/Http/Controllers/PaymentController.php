<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKelas;
use App\Models\JadwalKelas;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    /**
     * Tampilkan halaman checkout
     */
    public function checkout($kelasId = null): View
    {
        $userId = auth()->id();

        // Mengambil tagihan yang masih pending
        $pembayaranPending = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $kelasInfo = null;
        $jadwalList = collect();

        // Jika user memilih kelas baru
        if ($kelasId) {
            /** @var MasterKelas $kelasInfo */
            $kelasInfo = MasterKelas::query()->findOrFail($kelasId);
            $jadwalList = JadwalKelas::query()
                ->with('masterPengajar')
                ->where('kelas_id', $kelasId)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('siswa.checkout', compact('pembayaranPending', 'kelasInfo', 'jadwalList'));
    }

    /**
     * Proses pembuatan transaksi Midtrans
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_kelas,id'
        ]);

        $userId = auth()->id();
        
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $jadwalId = $request->jadwal_id;

        try {
            DB::beginTransaction();

            /** @var JadwalKelas $jadwal */
            $jadwal = JadwalKelas::query()->with('masterKelas')->lockForUpdate()->findOrFail($jadwalId);

            // 1. Cek apakah sudah ada transaksi PENDING untuk jadwal ini (Reuse)
            /** @var TransaksiPembayaran|null $transaksi */
            $transaksi = TransaksiPembayaran::query()
                ->where('user_id', $userId)
                ->where('jadwal_id', $jadwalId)
                ->where('status_pembayaran', 'pending')
                ->first();

            // Jika sudah terdaftar (Lunas)
            $isLunas = TransaksiPembayaran::query()
                ->where('user_id', $userId)
                ->where('jadwal_id', $jadwalId)
                ->where('status_pembayaran', 'settlement')
                ->exists();

            if ($isLunas) {
                DB::rollBack();
                return response('', 200)->json([
                    'status' => 'error',
                    'message' => 'Anda sudah terdaftar di kelas ini.'
                ], 422);
            }

            // Jika belum ada record pending, buat baru
            if (!$transaksi) {
                $transaksi = new TransaksiPembayaran();
                $transaksi->order_id = "EQ-" . time() . "-" . Str::random(5);
                $transaksi->user_id = $userId;
                $transaksi->jadwal_id = $jadwalId;
                $transaksi->jumlah_bayar = $jadwal->masterKelas->harga + 2500;
                $transaksi->status_pembayaran = 'pending';
            }

            // 2. Generate Snap Token jika belum ada atau kadaluwarsa
            if (!$transaksi->snap_token) {
                $params = [
                    'transaction_details' => [
                        'order_id' => $transaksi->order_id,
                        'gross_amount' => $transaksi->jumlah_bayar,
                    ],
                    'customer_details' => [
                        'first_name' => $user->nama_lengkap ?? 'Siswa',
                        'email'      => $user->email ?? 'siswa@example.com',
                    ]
                ];

                $serverKey = config('services.midtrans.server_key');
                $isProduction = config('services.midtrans.is_production');
                $baseUrl = $isProduction 
                    ? 'https://app.midtrans.com/snap/v1/transactions' 
                    : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

                $response = Http::withoutVerifying()
                    ->withBasicAuth($serverKey, '')
                    ->post($baseUrl, $params);

                if ($response->successful()) {
                    $transaksi->snap_token = $response->json('token');
                } else {
                    Log::error('Midtrans Snap Error: ' . $response->body());
                    throw new \Exception('Gagal mendapatkan token Midtrans');
                }
            }

            $transaksi->save();
            DB::commit();

            // Catat log aktivitas pendaftaran kelas
            catatLog('memulai proses pembayaran kelas', $transaksi, [
                'jadwal_id' => $jadwalId,
                'order_id' => $transaksi->order_id,
                'jumlah' => $transaksi->jumlah_bayar
            ]);

            return response('', 200)->json([
                'status' => 'success',
                'snap_token' => $transaksi->snap_token
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Payment Process: ' . $e->getMessage());
            return response('', 200)->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Handle Webhook dari Midtrans
     */
    public function handleNotification(Request $request): JsonResponse
    {
        Log::info('Midtrans Webhook:', $request->all());

        $serverKey = config('services.midtrans.server_key');

        // 2. Validasi Signature Key (Keamanan)
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
        if ($hashed !== $request->signature_key) {
            Log::warning('Midtrans Webhook: Invalid Signature Key');
            return response('', 200)->json(['message' => 'Invalid signature'], 403);
        }

        // 3. Ambil data transaksi
        /** @var TransaksiPembayaran|null $transaksi */
        $transaksi = TransaksiPembayaran::query()->where('order_id', $request->order_id)->first();

        if (!$transaksi) {
            Log::error('Midtrans Webhook: Order ID not found: ' . $request->order_id);
            return response('', 200)->json(['message' => 'Order not found'], 404);
        }

        // 4. Update Status Berdasarkan Notification
        $transactionStatus = $request->transaction_status;
        $type = $request->payment_type;
        $fraudStatus = $request->fraud_status;

        if ($transactionStatus == 'capture') {
            if ($type == 'credit_card') {
                if ($fraudStatus == 'challenge') {
                    $transaksi->status_pembayaran = 'pending';
                } else {
                    $transaksi->status_pembayaran = 'settlement';
                    $transaksi->tanggal_bayar = now();
                }
            }
        } else if ($transactionStatus == 'settlement') {
            $transaksi->status_pembayaran = 'settlement';
            $transaksi->tanggal_bayar = now();
        } else if ($transactionStatus == 'pending') {
            $transaksi->status_pembayaran = 'pending';
        } else if ($transactionStatus == 'deny') {
            $transaksi->status_pembayaran = 'cancel';
        } else if ($transactionStatus == 'expire') {
            $transaksi->status_pembayaran = 'expire';
        } else if ($transactionStatus == 'cancel') {
            $transaksi->status_pembayaran = 'cancel';
        }

        $transaksi->save();

        return response('', 200)->json(['status' => 'success']);
    }

    /**
     * Batalkan pembayaran oleh user
     */
    public function cancelPayment($id): RedirectResponse
    {
        $userId = auth()->id();

        /** @var TransaksiPembayaran $transaksi */
        $transaksi = TransaksiPembayaran::query()
            ->where('id', $id)
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->firstOrFail();

        $transaksi->status_pembayaran = 'cancel';
        $transaksi->save();

        catatLog('membatalkan pembayaran kelas', $transaksi, [
            'order_id' => $transaksi->order_id
        ]);

        return redirect()->route('siswa.dashboard')->with([
            'message' => 'Pembayaran berhasil dibatalkan.',
            'message_type' => 'success'
        ]);
    }
}
