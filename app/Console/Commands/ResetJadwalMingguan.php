<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\JadwalKelas;

#[Signature('jadwal:reset-mingguan')]
#[Description('Reset status jadwal kelas mingguan ke kondisi awal (upcoming)')]
class ResetJadwalMingguan extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Jika Anda masih ingin mempertahankan kolom 'status' di tabel database 
        // sebagai penanda fisik, kita bisa mereset semuanya menjadi 'upcoming'.
        $count = JadwalKelas::where('status', '!=', 'upcoming')->update(['status' => 'upcoming']);

        $this->info("Berhasil mereset {$count} jadwal kelas ke status upcoming untuk minggu ini.");
    }
}
