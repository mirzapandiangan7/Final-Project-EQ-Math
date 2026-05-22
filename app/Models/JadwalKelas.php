<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'jadwal_kelas';

    protected $fillable = [
        'kelas_id',
        'pengajar_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    // Menambahkan custom attribute agar selalu disertakan saat object di-load
    protected $appends = ['status_jadwal'];

    /**
     * Accessor untuk mendapatkan status secara real-time.
     * Logika ini HANYA membandingkan Urutan Hari dan Rentang Jam (Siklus Mingguan).
     */
    public function getStatusJadwalAttribute()
    {
        // 1. Ambil waktu sekarang (Hanya butuh Jam & Urutan Hari)
        // Sekarang menggunakan timezone global yang sudah diatur ke 'Asia/Jakarta'
        $now = \Carbon\Carbon::now();
        $hariIniNum = $now->isoWeekday(); // Senin=1, Minggu=7
        $jamSekarang = $now->format('H:i:s');

        // 2. Mapping Hari Indonesia (Case-insensitive & Trimmed)
        $mapHari = [
            'senin'  => 1,
            'selasa' => 2,
            'rabu'   => 3,
            'kamis'  => 4,
            'jumat'  => 5,
            'sabtu'  => 6,
            'minggu' => 7,
        ];

        // Normalisasi input dari database (contoh: 'Senin ' -> 'senin')
        $hariDatabase = strtolower(trim($this->hari));
        $hariJadwalNum = $mapHari[$hariDatabase] ?? null;

        if (!$hariJadwalNum) {
            return 'upcoming'; // Fallback jika format hari di DB tidak dikenal
        }

        // -------------------------------------------------------------------------
        // LOGIKA PERBANDINGAN SIKLUS MINGGUAN (Abaikan Tanggal/Tahun)
        // -------------------------------------------------------------------------

        // A. JIKA HARI INI SUDAH MELEWATI HARI JADWAL (Misal: Jadwal Senin, Sekarang Selasa)
        if ($hariIniNum > $hariJadwalNum) {
            return 'completed';
        }

        // B. JIKA HARI INI BELUM MENCAPAI HARI JADWAL (Misal: Jadwal Jumat, Sekarang Rabu)
        if ($hariIniNum < $hariJadwalNum) {
            return 'upcoming';
        }

        // C. JIKA HARI INI ADALAH HARI JADWAL (Perbandingan Jam Saja)
        if ($hariIniNum === $hariJadwalNum) {
            
            // Cek apakah sudah lewat jam selesai
            if ($jamSekarang > $this->jam_selesai) {
                return 'completed';
            }

            // Cek apakah sedang berlangsung (antara jam mulai dan jam selesai)
            if ($jamSekarang >= $this->jam_mulai && $jamSekarang <= $this->jam_selesai) {
                return 'active';
            }

            // Jika masih hari yang sama tapi belum masuk jam mulai
            return 'upcoming';
        }

        return 'upcoming';
    }

    public function masterKelas()
    {
        return $this->belongsTo(MasterKelas::class, 'kelas_id');
    }

    public function masterPengajar()
    {
        return $this->belongsTo(MasterPengajar::class, 'pengajar_id');
    }

    public function transaksiPembayaran()
    {
        return $this->hasMany(TransaksiPembayaran::class, 'jadwal_id');
    }
}
