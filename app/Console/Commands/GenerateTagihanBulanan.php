<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TransaksiPembayaran;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GenerateTagihanBulanan extends Command
{
    /**
     * Nama dan signature dari command (digunakan di terminal).
     */
    protected $signature = 'billing:generate-monthly';

    /**
     * Deskripsi command yang muncul saat php artisan list.
     */
    protected $description = 'Otomatis men-generate tagihan bulanan baru untuk siswa yang masa aktifnya habis (30 hari).';

    /**
     * Eksekusi logika utama command.
     */
    public function handle()
    {
        $this->info('Memulai pengecekan tagihan bulanan...');

        // 1. Tentukan batas waktu (30 hari yang lalu)
        $tigaPuluhHariLalu = Carbon::now()->subDays(30);

        // 2. Ambil transaksi terakhir yang sukses yang sudah berumur 30 hari atau lebih
        // Kita grouping berdasarkan user_id dan jadwal_id untuk mendapatkan record terbaru per kelas
        $transaksiLunas = TransaksiPembayaran::query()
            ->where('status_pembayaran', 'settlement')
            ->whereDate('tanggal_bayar', '<=', $tigaPuluhHariLalu)
            ->get();

        $count = 0;

        foreach ($transaksiLunas as $lastTrx) {
            
            // 3. CEK DUPLIKASI: Pastikan belum ada tagihan pending untuk user dan jadwal ini di siklus baru
            // Kita cek apakah ada transaksi (baik pending maupun lunas) yang dibuat SETELAH tanggal bayar terakhir
            $sudahAdaTagihanBaru = TransaksiPembayaran::query()
                ->where('user_id', $lastTrx->user_id)
                ->where('jadwal_id', $lastTrx->jadwal_id)
                ->where('created_at', '>', $lastTrx->tanggal_bayar)
                ->exists();

            if (!$sudahAdaTagihanBaru) {
                // 4. GENERATE TAGIHAN BARU
                try {
                    $newTrx = new TransaksiPembayaran();
                    $newTrx->order_id = "RECUR-" . time() . "-" . Str::random(5);
                    $newTrx->user_id = $lastTrx->user_id;
                    $newTrx->jadwal_id = $lastTrx->jadwal_id;
                    $newTrx->jumlah_bayar = $lastTrx->jumlah_bayar; // Menggunakan harga yang sama dengan sebelumnya
                    $newTrx->status_pembayaran = 'pending';
                    $newTrx->tanggal_bayar = null; // Belum dibayar
                    $newTrx->save();

                    // Catat log aktivitas (Opsional, menggunakan helper catatLog yang sudah ada)
                    if (function_exists('catatLog')) {
                        catatLog('otomatis men-generate tagihan bulanan', $newTrx, [
                            'original_order_id' => $lastTrx->order_id,
                            'new_order_id' => $newTrx->order_id
                        ]);
                    }

                    $this->line("Berhasil membuat tagihan untuk User ID: {$newTrx->user_id} di Jadwal ID: {$newTrx->jadwal_id}");
                    $count++;
                } catch (\Exception $e) {
                    Log::error("Gagal generate tagihan otomatis: " . $e->getMessage());
                    $this->error("Error pada User ID: {$lastTrx->user_id}");
                }
            }
        }

        $this->info("Selesai! Berhasil men-generate {$count} tagihan baru.");
        return Command::SUCCESS;
    }
}
