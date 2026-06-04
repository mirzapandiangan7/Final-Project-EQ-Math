<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiPembayaran;
use App\Models\MasterKelas;
use App\Models\JadwalKelas;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaRiwayatExport;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Database\Eloquent\Builder;

class SiswaController extends Controller
{
    /**
     * Dashboard Siswa
     */
    public function index(): View
    {
        $userId = auth()->id();

        // Get user active classes
        $kelasAktif = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas', 'jadwalKelas.masterPengajar'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'settlement')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        // Get next class
        $kelasBerikutnya = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas', 'jadwalKelas.masterPengajar'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'settlement')
            ->orderBy('tanggal_bayar', 'asc')
            ->first();

        // Get pending payments
        $pembayaranPending = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'pending')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        // Get transaction history
        $riwayatTransaksi = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas'])
            ->where('user_id', $userId)
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(5)
            ->get();

        // Get available classes
        $kelasTersedia = MasterKelas::query()
            ->orderBy('jenjang')
            ->orderBy('nama_kelas')
            ->get();

        // Get total pembayaran
        $totalPembayaran = TransaksiPembayaran::query()
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'settlement')
            ->sum('jumlah_bayar');

        return view('siswa.dashboard', compact(
            'kelasAktif',
            'kelasBerikutnya',
            'pembayaranPending',
            'riwayatTransaksi',
            'kelasTersedia',
            'totalPembayaran'
        ));
    }

    /**
     * Halaman pendaftaran kelas
     */
    public function pendaftaran(): View
    {
        $allKelas = MasterKelas::query()
            ->withCount([
                'jadwalKelas as jumlah_jadwal',
                'transaksiPembayaran as jumlah_siswa' => function (Builder $query) {
                    $query->where('status_pembayaran', 'settlement');
                }
            ])
            ->orderBy('jenjang')
            ->orderBy('nama_kelas')
            ->get();

        return view('siswa.pendaftaran', compact('allKelas'));
    }

    /**
     * Riwayat transaksi siswa
     */
    public function riwayat(): View
    {
        $userId = auth()->id();
        $riwayats = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas', 'jadwalKelas.masterPengajar'])
            ->where('user_id', $userId)
            ->orderBy('tanggal_bayar', 'desc')
            ->get();
            
        return view('siswa.riwayat', compact('riwayats'));
    }

    /**
     * Export riwayat ke Excel
     */
    public function exportRiwayat(): BinaryFileResponse
    {
        return Excel::download(new SiswaRiwayatExport, 'riwayat-pembayaran-saya.xlsx');
    }

    /**
     * Daftar kelas yang diikuti
     */
    public function kelasSaya(): View
    {
        $userId = auth()->id();
        $kelasSaya = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas', 'jadwalKelas.masterPengajar'])
            ->where('user_id', $userId)
            ->where('status_pembayaran', 'settlement')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        return view('siswa.kelas_saya', compact('kelasSaya'));
    }

    /**
     * Halaman bantuan
     */
    public function bantuan(): View
    {
        return view('siswa.bantuan', []);
    }
}
