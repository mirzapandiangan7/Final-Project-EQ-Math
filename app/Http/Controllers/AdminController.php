<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\MasterPengajar;
use App\Models\MasterKelas;
use App\Models\JadwalKelas;
use App\Models\TransaksiPembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AdminTransaksiExport;
use App\Exports\AdminPengajarExport;
use App\Exports\AdminJadwalExport;
use App\Exports\AdminSiswaExport;
use App\Exports\AdminKelasExport;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalPengajar = MasterPengajar::count();
        $totalKelas = MasterKelas::count();
        
        $pendapatanBulanIni = TransaksiPembayaran::where('status_pembayaran', 'settlement')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah_bayar');

        $siswaBaru = User::where('role', 'siswa')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $transaksiTerbaru = TransaksiPembayaran::with(['user', 'jadwalKelas.masterKelas'])
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 
            'totalPengajar', 
            'totalKelas', 
            'pendapatanBulanIni',
            'siswaBaru',
            'transaksiTerbaru'
        ));
    }

    // --- PENGAJAR ---
    public function pengajarIndex()
    {
        $pengajar = MasterPengajar::orderBy('id', 'asc')->get();
        return view('admin.pengajar', compact('pengajar'));
    }

    public function pengajarStore(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        $pengajar = MasterPengajar::create(['nama_pengajar' => $request->nama]);
        ActivityLog::log('created pengajar', $pengajar, [
            'attributes' => $pengajar->toArray(),
        ]);

        return redirect()->route('admin.pengajar.index')->with(['message' => 'Pengajar berhasil ditambahkan', 'message_type' => 'success']);
    }

    public function pengajarUpdate(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:100']);
        $pengajar = MasterPengajar::findOrFail($id);
        $original = $pengajar->getOriginal();
        $pengajar->update(['nama_pengajar' => $request->nama]);

        ActivityLog::log('updated pengajar', $pengajar, [
            'old' => $original,
            'attributes' => $pengajar->getChanges(),
        ]);

        return redirect()->route('admin.pengajar.index')->with(['message' => 'Pengajar berhasil diperbarui', 'message_type' => 'success']);
    }

    public function pengajarDestroy($id)
    {
        $pengajar = MasterPengajar::findOrFail($id);
        $old = $pengajar->toArray();
        $pengajar->delete();

        ActivityLog::log('deleted pengajar', $pengajar, [
            'old' => $old,
        ]);

        return redirect()->route('admin.pengajar.index')->with(['message' => 'Pengajar berhasil dihapus', 'message_type' => 'success']);
    }

    public function exportPengajar()
    {
        return Excel::download(new AdminPengajarExport, 'daftar-pengajar-eqmath.xlsx');
    }

    // --- KELAS ---
    public function kelasIndex()
    {
        $kelas = MasterKelas::withCount(['jadwalKelas as jumlah_jadwal'])
            ->withCount(['transaksiPembayaran as jumlah_siswa' => function ($query) {
                $query->where('status_pembayaran', 'settlement');
            }])
            ->orderBy('jenjang')->orderBy('nama_kelas')->get();

        return view('admin.kelas', compact('kelas'));
    }

    public function kelasStore(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string'
        ]);
        $kelas = MasterKelas::create($request->all());
        ActivityLog::log('created kelas', $kelas, [
            'attributes' => $kelas->toArray(),
        ]);

        return redirect()->route('admin.kelas.index')->with(['message' => 'Kelas berhasil ditambahkan', 'message_type' => 'success']);
    }

    public function kelasUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string'
        ]);
        $kelas = MasterKelas::findOrFail($id);
        $original = $kelas->getOriginal();
        $kelas->update($request->all());

        ActivityLog::log('updated kelas', $kelas, [
            'old' => $original,
            'attributes' => $kelas->getChanges(),
        ]);

        return redirect()->route('admin.kelas.index')->with(['message' => 'Kelas berhasil diperbarui', 'message_type' => 'success']);
    }

    public function kelasDestroy($id)
    {
        $kelas = MasterKelas::findOrFail($id);
        $old = $kelas->toArray();
        $kelas->delete();

        ActivityLog::log('deleted kelas', $kelas, [
            'old' => $old,
        ]);

        return redirect()->route('admin.kelas.index')->with(['message' => 'Kelas berhasil dihapus', 'message_type' => 'success']);
    }

    public function exportKelas()
    {
        return Excel::download(new AdminKelasExport, 'daftar-kelas-eqmath.xlsx');
    }

    // --- JADWAL ---
    public function jadwalIndex()
    {
        $jadwal = JadwalKelas::with(['masterKelas', 'masterPengajar'])
            ->orderBy('hari')->orderBy('jam_mulai')->get();
        $kelas = MasterKelas::orderBy('jenjang')->orderBy('nama_kelas')->get();
        $pengajar = MasterPengajar::orderBy('nama_pengajar')->get();

        return view('admin.jadwal', compact('jadwal', 'kelas', 'pengajar'));
    }

    public function jadwalStore(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:master_kelas,id',
            'pengajar_id' => 'required|exists:master_pengajar,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        try {
            // Memulai transaksi database (Atomicity)
            // Memastikan pembuatan jadwal hanya berhasil jika tidak ada error selama proses validasi overlap
            DB::beginTransaction();

            // --------------------------------------------------------------------------
            // VALIDASI KONFLIK JADWAL (ADMIN - STORE)
            // --------------------------------------------------------------------------
            // Menggunakan lockForUpdate() agar data yang sedang dibaca tidak bisa diubah transaksi lain
            $clash = JadwalKelas::where('pengajar_id', $request->pengajar_id)
                ->where('hari', $request->hari)
                ->where(function ($query) use ($request) {
                    $query->where('jam_mulai', '<', $request->jam_selesai)
                          ->where('jam_selesai', '>', $request->jam_mulai);
                })
                ->lockForUpdate()
                ->exists();

            if ($clash) {
                // Batalkan transaksi jika terjadi bentrok jadwal
                DB::rollBack();

                return redirect()->back()->withErrors([
                    'jam_mulai' => 'Gagal! Pengajar ini sudah memiliki kelas lain yang beririsan di hari dan jam tersebut.'
                ])->withInput();
            }

            $jadwal = JadwalKelas::create(array_merge($request->all(), ['status' => 'upcoming']));

            ActivityLog::log('created jadwal', $jadwal, [
                'attributes' => $jadwal->toArray(),
            ]);

            // Jika berhasil dan tidak ada error/bentrok, commit data ke database
            DB::commit();

            return redirect()->route('admin.jadwal.index')->with([
                'message' => 'Jadwal berhasil ditambahkan', 
                'message_type' => 'success'
            ]);

        } catch (\Exception $e) {
            // Rollback jika terjadi exception (misal: koneksi terputus saat menyimpan)
            DB::rollBack();

            // Simpan log error asli untuk backend developer
            Log::error('Error Pembuatan Jadwal Kelas: ' . $e->getMessage());

            return back()->with([
                'message' => 'Terjadi kesalahan sistem, transaksi dibatalkan dengan aman.',
                'message_type' => 'error'
            ])->withInput();
        }
    }

    public function jadwalUpdate(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:master_kelas,id',
            'pengajar_id' => 'required|exists:master_pengajar,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:active,upcoming,completed'
        ]);

        $clash = JadwalKelas::where('pengajar_id', $request->pengajar_id)
            ->where('hari', $request->hari)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->where('jam_mulai', '<', $request->jam_selesai)
                      ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($clash) {
            return redirect()->back()->withErrors([
                'jam_mulai' => 'Gagal! Update bentrok dengan kelas lain yang diampu pengajar tersebut di hari dan jam yang sama.'
            ])->withInput();
        }

        $jadwal = JadwalKelas::findOrFail($id);
        $original = $jadwal->getOriginal();
        $jadwal->update($request->all());

        ActivityLog::log('updated jadwal', $jadwal, [
            'old' => $original,
            'attributes' => $jadwal->getChanges(),
        ]);

        return redirect()->route('admin.jadwal.index')->with(['message' => 'Jadwal berhasil diperbarui', 'message_type' => 'success']);
    }

    public function jadwalDestroy($id)
    {
        $jadwal = JadwalKelas::findOrFail($id);
        $old = $jadwal->toArray();
        $jadwal->delete();

        ActivityLog::log('deleted jadwal', $jadwal, [
            'old' => $old,
        ]);

        return redirect()->route('admin.jadwal.index')->with(['message' => 'Jadwal berhasil dihapus', 'message_type' => 'success']);
    }

    public function exportJadwal()
    {
        return Excel::download(new AdminJadwalExport, 'daftar-jadwal-eqmath.xlsx');
    }

    // --- PEMBAYARAN ---
    public function pembayaranIndex()
    {
        $transaksis = TransaksiPembayaran::with(['user', 'jadwalKelas.masterKelas'])
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalPendapatan = TransaksiPembayaran::where('status_pembayaran', 'settlement')
            ->sum('jumlah_bayar');

        $pendingCount = TransaksiPembayaran::where('status_pembayaran', 'pending')->count();
        $settlementCount = TransaksiPembayaran::where('status_pembayaran', 'settlement')->count();

        return view('admin.pembayaran', compact('transaksis', 'totalPendapatan', 'pendingCount', 'settlementCount'));
    }

    public function updatePembayaranStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,settlement,cancel'
        ]);

        $transaksi = TransaksiPembayaran::findOrFail($id);
        $oldStatus = $transaksi->status_pembayaran;
        $transaksi->status_pembayaran = $request->status;
        if ($request->status === 'settlement' && !$transaksi->tanggal_bayar) {
            $transaksi->tanggal_bayar = now();
        }
        $transaksi->save();

        ActivityLog::log('updated pembayaran status', $transaksi, [
            'old' => ['status_pembayaran' => $oldStatus],
            'attributes' => ['status_pembayaran' => $transaksi->status_pembayaran, 'tanggal_bayar' => $transaksi->tanggal_bayar],
        ]);

        return redirect()->back()->with([
            'message' => 'Status pembayaran berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function exportTransaksi()
    {
        return Excel::download(new AdminTransaksiExport, 'laporan-transaksi-eqmath.xlsx');
    }

    // --- SISWA ---
    public function siswaIndex()
    {
        $siswa = User::where('role', 'siswa')
            ->with(['transaksiPembayaran' => function ($query) {
                $query->with('jadwalKelas.masterKelas')
                      ->where('status_pembayaran', 'settlement')
                      ->orderBy('tanggal_bayar', 'desc');
            }])
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.siswa', compact('siswa'));
    }

    public function exportSiswa()
    {
        return Excel::download(new AdminSiswaExport, 'daftar-siswa-eqmath.xlsx');
    }

    // --- PENGATURAN ---
    public function pengaturanIndex()
    {
        return view('admin.pengaturan');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'no_wa' => 'nullable|string|max:20'
        ]);

        $user = User::findOrFail(Auth::id());
        $original = $user->only('nama_lengkap', 'email', 'no_wa');
        $user->update($request->only('nama_lengkap', 'email', 'no_wa'));

        ActivityLog::log('updated profile', $user, [
            'old' => $original,
            'attributes' => $request->only('nama_lengkap', 'email', 'no_wa'),
        ]);

        return redirect()->back()->with(['message' => 'Profil berhasil diperbarui', 'message_type' => 'success']);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::findOrFail(Auth::id());

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with(['message' => 'Password saat ini salah', 'message_type' => 'error']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        ActivityLog::log('updated password', $user, [
            'attributes' => ['password' => 'updated'],
        ]);

        return redirect()->back()->with(['message' => 'Password berhasil diubah', 'message_type' => 'success']);
    }
}
