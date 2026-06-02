<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterKelas;
use App\Models\JadwalKelas;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function checkout($kelasId = null)
    {
        $userId = Auth::id();

        // Mengambil tagihan yang masih pending
        $pembayaranPending = TransaksiPembayaran::with(['jadwalKelas.masterKelas'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $kelasInfo = null;
        $jadwalList = collect();

        // Jika user memilih kelas baru
        if ($kelasId) {
            $kelasInfo = MasterKelas::findOrFail($kelasId);
            $jadwalList = JadwalKelas::with('masterPengajar')
                ->where('kelas_id', $kelasId)
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('siswa.checkout', compact('pembayaranPending', 'kelasInfo', 'jadwalList'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_kelas,id'
        ]);

        $userId = Auth::id();
        $user = Auth::user();
        $jadwalId = $request->jadwal_id;

        try {
            DB::beginTransaction();

            $jadwal = JadwalKelas::with('masterKelas')->lockForUpdate()->findOrFail($jadwalId);

            // 1. Cek apakah sudah ada transaksi PENDING untuk jadwal ini (Reuse)
            $transaksi = TransaksiPembayaran::where('user_id', $userId)
                ->where('jadwal_id', $jadwalId)
                ->where('status_pembayaran', 'pending')
                ->first();

            // Jika sudah terdaftar (Lunas)
            $isLunas = TransaksiPembayaran::where('user_id', $userId)
                ->where('jadwal_id', $jadwalId)
                ->where('status_pembayaran', 'settlement')
                ->exists();

            if ($isLunas) {
                DB::rollBack();
                return response()->json([
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

                $serverKey = env('MIDTRANS_SERVER_KEY');
                $response = Http::withoutVerifying()
                    ->withBasicAuth($serverKey, '')
                    ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

                if ($response->successful()) {
                    $transaksi->snap_token = $response->json('token');
                } else {
                    throw new \Exception('Gagal mendapatkan token Midtrans');
                }
            }

            $transaksi->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'snap_token' => $transaksi->snap_token
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Payment Process: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem, silakan coba lagi.'
            ], 500);
        }
    }

    public function webhook(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $transaksi = TransaksiPembayaran::where('order_id', $request->order_id)->first();

            if ($transaksi) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    $transaksi->status_pembayaran = 'settlement';
                    $transaksi->tanggal_bayar = now();
                } else if ($request->transaction_status == 'expire' || $request->transaction_status == 'cancel' || $request->transaction_status == 'deny') {
                    $transaksi->status_pembayaran = 'cancel';
                }
                $transaksi->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function cancelPayment($id)
    {
        $userId = Auth::id();
        
        // Cari transaksi berdasarkan ID dan pastikan milik user yang login
        $transaksi = TransaksiPembayaran::where('id', $id)
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->firstOrFail();

        // Ubah status menjadi 'cancel'
        $transaksi->status_pembayaran = 'cancel';
        $transaksi->save();

        return redirect()->route('siswa.dashboard')->with([
            'message' => 'Pembayaran berhasil dibatalkan.',
            'message_type' => 'success'
        ]);
    }
}