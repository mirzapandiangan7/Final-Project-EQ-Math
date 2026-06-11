<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Database\Eloquent\Builder;

class AdminController extends Controller
{
    /**
     * Tampilkan Dashboard Admin
     */
    public function dashboard(): View
    {
        $totalSiswa = User::query()->where('role', 'siswa')->count();
        $totalPengajar = MasterPengajar::query()->count();
        $totalKelas = MasterKelas::query()->count();

        $pendapatanBulanIni = TransaksiPembayaran::query()
            ->where('status_pembayaran', 'settlement')
            ->whereMonth('tanggal_bayar', now()->month)
            ->whereYear('tanggal_bayar', now()->year)
            ->sum('jumlah_bayar');

        $siswaBaru = User::query()
            ->where('role', 'siswa')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $transaksiTerbaru = TransaksiPembayaran::query()
            ->with(['user', 'jadwalKelas.masterKelas'])
            ->orderBy('tanggal_bayar', 'desc')
            ->take(5)
            ->get();

        // === DATA CHART ===

        // 1. Grafik Pendapatan Bulanan (Line Chart)
        $currentYear = now()->year;
        $monthlyRevenueLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $monthlyRevenueData = array_fill(0, 12, 0);

        $monthlyTransactions = TransaksiPembayaran::query()
            ->where('status_pembayaran', 'settlement')
            ->whereYear('tanggal_bayar', $currentYear)
            ->whereNotNull('tanggal_bayar')
            ->get();

        $monthlyRevenueCollection = $monthlyTransactions->groupBy(function (TransaksiPembayaran $item) {
            return Carbon::parse($item->tanggal_bayar)->month;
        })->map(function ($group) {
            return $group->sum('jumlah_bayar');
        });

        foreach ($monthlyRevenueCollection as $month => $total) {
            if ($month >= 1 && $month <= 12) {
                $monthlyRevenueData[$month - 1] = $total;
            }
        }

        // 2. Grafik Status Pembayaran (Doughnut Chart)
        $paymentStatusLabels = ['Pending', 'Settlement', 'Cancel', 'Expire'];
        $paymentStatusData = [
            TransaksiPembayaran::query()->where('status_pembayaran', 'pending')->count(),
            TransaksiPembayaran::query()->where('status_pembayaran', 'settlement')->count(),
            TransaksiPembayaran::query()->where('status_pembayaran', 'cancel')->count(),
            TransaksiPembayaran::query()->where('status_pembayaran', 'expire')->count(),
        ];

        // 3. Grafik Pendapatan per Kelas (Bar Chart)
        $revenueByClassCollection = TransaksiPembayaran::query()
            ->with(['jadwalKelas.masterKelas'])
            ->where('status_pembayaran', 'settlement')
            ->whereHas('jadwalKelas.masterKelas')
            ->get()
            ->groupBy(function (TransaksiPembayaran $item) {
                return $item->jadwalKelas->masterKelas->nama_kelas ?? 'Tidak diketahui';
            })->map(function ($group) {
                return $group->sum('jumlah_bayar');
            })->sortDesc()->take(10);

        $revenueByClassLabels = $revenueByClassCollection->keys()->toArray();
        $revenueByClassData = $revenueByClassCollection->values()->toArray();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPengajar',
            'totalKelas',
            'pendapatanBulanIni',
            'siswaBaru',
            'transaksiTerbaru',
            'monthlyRevenueLabels',
            'monthlyRevenueData',
            'paymentStatusLabels',
            'paymentStatusData',
            'revenueByClassLabels',
            'revenueByClassData'
        ));
    }

    // --- PENGAJAR ---
    public function pengajarIndex(): View
    {
        $pengajar = MasterPengajar::query()->orderBy('id', 'asc')->get();
        return view('admin.pengajar', compact('pengajar'));
    }

    public function pengajarStore(Request $request): RedirectResponse
    {
        $validated = $request->validate(['nama' => 'required|string|max:100']);
        
        /** @var MasterPengajar $pengajar */
        $pengajar = MasterPengajar::query()->create(['nama_pengajar' => $validated['nama']]);

        ActivityLog::log('created pengajar', $pengajar, [
            'attributes' => $pengajar->toArray(),
        ]);

        return redirect()->route('admin.pengajar.index')->with([
            'message' => 'Pengajar berhasil ditambahkan',
            'message_type' => 'success'
        ]);
    }

    public function pengajarUpdate(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate(['nama' => 'required|string|max:100']);
        
        /** @var MasterPengajar $pengajar */
        $pengajar = MasterPengajar::query()->findOrFail($id);
        $original = $pengajar->getOriginal();
        $pengajar->update(['nama_pengajar' => $validated['nama']]);

        ActivityLog::log('updated pengajar', $pengajar, [
            'old' => $original,
            'attributes' => $pengajar->getChanges(),
        ]);

        return redirect()->route('admin.pengajar.index')->with([
            'message' => 'Pengajar berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function pengajarDestroy($id): RedirectResponse
    {
        /** @var MasterPengajar $pengajar */
        $pengajar = MasterPengajar::query()->findOrFail($id);
        $old = $pengajar->toArray();
        $pengajar->delete();

        ActivityLog::log('deleted pengajar', $pengajar, [
            'old' => $old,
        ]);

        return redirect()->route('admin.pengajar.index')->with([
            'message' => 'Pengajar berhasil dihapus',
            'message_type' => 'success'
        ]);
    }

    public function exportPengajar(): BinaryFileResponse
    {
        return Excel::download(new AdminPengajarExport, 'daftar-pengajar-eqmath.xlsx');
    }

    // --- KELAS ---
    public function kelasIndex(): View
    {
        $kelas = MasterKelas::query()
            ->withCount(['jadwalKelas as jumlah_jadwal'])
            ->withCount(['transaksiPembayaran as jumlah_siswa' => function (Builder $query) {
                $query->where('status_pembayaran', 'settlement');
            }])
            ->orderBy('jenjang')
            ->orderBy('nama_kelas')
            ->get();

        return view('admin.kelas', compact('kelas'));
    }

    public function kelasStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string'
        ]);

        /** @var MasterKelas $kelas */
        $kelas = MasterKelas::query()->create($validated);

        ActivityLog::log('created kelas', $kelas, [
            'attributes' => $kelas->toArray(),
        ]);

        return redirect()->route('admin.kelas.index')->with([
            'message' => 'Kelas berhasil ditambahkan',
            'message_type' => 'success'
        ]);
    }

    public function kelasUpdate(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'jenjang' => 'required|in:SD,SMP,SMA',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string'
        ]);

        /** @var MasterKelas $kelas */
        $kelas = MasterKelas::query()->findOrFail($id);
        $original = $kelas->getOriginal();
        $kelas->update($validated);

        ActivityLog::log('updated kelas', $kelas, [
            'old' => $original,
            'attributes' => $kelas->getChanges(),
        ]);

        return redirect()->route('admin.kelas.index')->with([
            'message' => 'Kelas berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function kelasDestroy($id): RedirectResponse
    {
        /** @var MasterKelas $kelas */
        $kelas = MasterKelas::query()->findOrFail($id);
        $old = $kelas->toArray();
        $kelas->delete();

        ActivityLog::log('deleted kelas', $kelas, [
            'old' => $old,
        ]);

        return redirect()->route('admin.kelas.index')->with([
            'message' => 'Kelas berhasil dihapus',
            'message_type' => 'success'
        ]);
    }

    public function exportKelas(): BinaryFileResponse
    {
        return Excel::download(new AdminKelasExport, 'daftar-kelas-eqmath.xlsx');
    }

    // --- JADWAL ---
    public function jadwalIndex(): View
    {
        $jadwal = JadwalKelas::query()
            ->with(['masterKelas', 'masterPengajar'])
            ->orderBy('hari')->orderBy('jam_mulai')->get();
            
        $kelas = MasterKelas::query()->orderBy('jenjang')->orderBy('nama_kelas')->get();
        $pengajar = MasterPengajar::query()->orderBy('nama_pengajar')->get();

        return view('admin.jadwal', compact('jadwal', 'kelas', 'pengajar'));
    }

    public function jadwalStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:master_kelas,id',
            'pengajar_id' => 'required|exists:master_pengajar,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        try {
            DB::beginTransaction();

            $clash = JadwalKelas::query()
                ->where('pengajar_id', $validated['pengajar_id'])
                ->where('hari', $validated['hari'])
                ->where(function (Builder $query) use ($validated) {
                    $query->where('jam_mulai', '<', $validated['jam_selesai'])
                        ->where('jam_selesai', '>', $validated['jam_mulai']);
                })
                ->lockForUpdate()
                ->exists();

            if ($clash) {
                DB::rollBack();
                return redirect()->back()->withErrors([
                    'jam_mulai' => 'Gagal! Pengajar ini sudah memiliki kelas lain yang beririsan di hari dan jam tersebut.'
                ])->withInput();
            }

            /** @var JadwalKelas $jadwal */
            $jadwal = JadwalKelas::query()->create(array_merge($validated, ['status' => 'upcoming']));

            ActivityLog::log('created jadwal', $jadwal, [
                'attributes' => $jadwal->toArray(),
            ]);

            DB::commit();

            return redirect()->route('admin.jadwal.index')->with([
                'message' => 'Jadwal berhasil ditambahkan',
                'message_type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error Pembuatan Jadwal Kelas: ' . $e->getMessage());

            return back()->with([
                'message' => 'Terjadi kesalahan sistem, transaksi dibatalkan dengan aman.',
                'message_type' => 'error'
            ])->withInput();
        }
    }

    public function jadwalUpdate(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:master_kelas,id',
            'pengajar_id' => 'required|exists:master_pengajar,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'required|in:active,upcoming,completed'
        ]);

        $clash = JadwalKelas::query()
            ->where('pengajar_id', $validated['pengajar_id'])
            ->where('hari', $validated['hari'])
            ->where('id', '!=', $id)
            ->where(function (Builder $query) use ($validated) {
                $query->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($clash) {
            return redirect()->back()->withErrors([
                'jam_mulai' => 'Gagal! Update bentrok dengan kelas lain yang diampu pengajar tersebut di hari dan jam yang sama.'
            ])->withInput();
        }

        /** @var JadwalKelas $jadwal */
        $jadwal = JadwalKelas::query()->findOrFail($id);
        $original = $jadwal->getOriginal();
        $jadwal->update($validated);

        ActivityLog::log('updated jadwal', $jadwal, [
            'old' => $original,
            'attributes' => $jadwal->getChanges(),
        ]);

        return redirect()->route('admin.jadwal.index')->with([
            'message' => 'Jadwal berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function jadwalDestroy($id): RedirectResponse
    {
        /** @var JadwalKelas $jadwal */
        $jadwal = JadwalKelas::query()->findOrFail($id);
        $old = $jadwal->toArray();
        $jadwal->delete();

        ActivityLog::log('deleted jadwal', $jadwal, [
            'old' => $old,
        ]);

        return redirect()->route('admin.jadwal.index')->with([
            'message' => 'Jadwal berhasil dihapus',
            'message_type' => 'success'
        ]);
    }

    public function exportJadwal(): BinaryFileResponse
    {
        return Excel::download(new AdminJadwalExport, 'daftar-jadwal-eqmath.xlsx');
    }

    /**
     * Tampilkan daftar peserta pada jadwal tertentu
     */
    public function jadwalPeserta($id): View
    {
        // Mengambil data jadwal beserta relasi kelas dan pengajarnya
        /** @var JadwalKelas $jadwal */
        $jadwal = JadwalKelas::query()
            ->with(['masterKelas', 'masterPengajar'])
            ->findOrFail($id);

        // FIX BUG PESERTA: Mengambil data peserta (siswa) dengan filter ketat
        // 1. Filter status_pembayaran hanya yang 'settlement' (Lunas/Berhasil)
        // 2. Gunakan unique('user_id') untuk memastikan satu siswa hanya muncul satu kali meskipun punya banyak riwayat transaksi
        $peserta = TransaksiPembayaran::query()
            ->with('user')
            ->where('jadwal_id', $id)
            // FIX BUG PESERTA: Hanya ambil yang sudah lunas (Settlement)
            ->where('status_pembayaran', 'settlement')
            ->get()
            // FIX BUG PESERTA: Hilangkan duplikasi jika siswa yang sama punya lebih dari satu transaksi sukses
            ->unique('user_id');

        return view('admin.jadwal_peserta', compact('jadwal', 'peserta'));
    }

    // --- PEMBAYARAN ---
    public function pembayaranIndex(): View
    {
        $transaksis = TransaksiPembayaran::query()
            ->with(['user', 'jadwalKelas.masterKelas'])
            ->orderBy('tanggal_bayar', 'desc')
            ->get();

        $totalPendapatan = TransaksiPembayaran::query()
            ->where('status_pembayaran', 'settlement')
            ->sum('jumlah_bayar');

        $pendingCount = TransaksiPembayaran::query()->where('status_pembayaran', 'pending')->count();
        $settlementCount = TransaksiPembayaran::query()->where('status_pembayaran', 'settlement')->count();

        return view('admin.pembayaran', compact('transaksis', 'totalPendapatan', 'pendingCount', 'settlementCount'));
    }

    public function updatePembayaranStatus(Request $request, $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,settlement,cancel'
        ]);

        /** @var TransaksiPembayaran $transaksi */
        $transaksi = TransaksiPembayaran::query()->findOrFail($id);
        $oldStatus = $transaksi->status_pembayaran;
        $transaksi->status_pembayaran = $validated['status'];

        if ($validated['status'] === 'settlement' && !$transaksi->tanggal_bayar) {
            $transaksi->tanggal_bayar = now();
        }

        $transaksi->save();

        ActivityLog::log('updated pembayaran status', $transaksi, [
            'old' => ['status_pembayaran' => $oldStatus],
            'attributes' => [
                'status_pembayaran' => $transaksi->status_pembayaran,
                'tanggal_bayar' => $transaksi->tanggal_bayar
            ],
        ]);

        return redirect()->back()->with([
            'message' => 'Status pembayaran berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function exportTransaksi(): BinaryFileResponse
    {
        return Excel::download(new AdminTransaksiExport, 'laporan-transaksi-eqmath.xlsx');
    }

    // --- SISWA ---
    public function siswaIndex(): View
    {
        $siswa = User::query()
            ->where('role', 'siswa')
            ->with(['transaksiPembayaran' => function ($query) { // FIX TYPE ERROR
                $query->with('jadwalKelas.masterKelas')
                    ->where('status_pembayaran', 'settlement')
                    ->orderBy('tanggal_bayar', 'desc');
            }])
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.siswa', compact('siswa'));
    }

    public function exportSiswa(): BinaryFileResponse
    {
        return Excel::download(new AdminSiswaExport, 'daftar-siswa-eqmath.xlsx');
    }

    // --- PENGATURAN ---
    public function pengaturanIndex(): View
    {
        return view('admin.pengaturan', []);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'no_wa' => 'nullable|string|max:20'
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        $original = $user->only('nama_lengkap', 'email', 'no_wa');
        $user->update($validated);

        ActivityLog::log('updated profile', $user, [
            'old' => $original,
            'attributes' => $validated,
        ]);

        return redirect()->back()->with([
            'message' => 'Profil berhasil diperbarui',
            'message_type' => 'success'
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with([
                'message' => 'Password saat ini salah',
                'message_type' => 'error'
            ]);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        ActivityLog::log('updated password', $user, [
            'attributes' => ['password' => 'updated'],
        ]);

        return redirect()->back()->with([
            'message' => 'Password berhasil diubah',
            'message_type' => 'success'
        ]);
    }
}
