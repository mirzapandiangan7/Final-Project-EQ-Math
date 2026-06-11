@extends('layouts.panel')

@section('title', 'Daftar Peserta Kelas')

@section('content')
<!-- Page Header -->
<div class="mb-8 fade-in">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-slate-500 mb-2">
                <a href="{{ route('admin.jadwal.index') }}" class="hover:text-blue-600 transition">Jadwal Kelas</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span>Daftar Peserta</span>
            </div>
            <h1 class="text-3xl font-bold text-slate-900">Daftar Peserta</h1>
            <p class="text-slate-500 mt-1">Siswa yang terdaftar pada jadwal ini</p>
        </div>
        <a href="{{ route('admin.jadwal.index') }}" class="inline-flex items-center px-4 py-2 border border-slate-200 rounded-xl hover:bg-slate-50 transition text-sm font-medium text-slate-600 bg-white">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>

<!-- Informasi Jadwal -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-8 fade-in">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <p class="text-sm font-medium text-slate-500">Nama Kelas</p>
            <p class="text-lg font-bold text-slate-900 mt-1">{{ $jadwal->masterKelas->nama_kelas }} ({{ $jadwal->masterKelas->jenjang }})</p>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Pengajar</p>
            <p class="text-lg font-bold text-slate-900 mt-1">{{ $jadwal->masterPengajar->nama_pengajar }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Waktu</p>
            <p class="text-lg font-bold text-slate-900 mt-1">{{ $jadwal->hari }}, {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
        </div>
        <div>
            <p class="text-sm font-medium text-slate-500">Total Peserta</p>
            <p class="text-lg font-bold text-slate-900 mt-1">{{ count($peserta) }} Siswa</p>
        </div>
    </div>
</div>

<!-- Daftar Peserta Table -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden fade-in">
    <div class="p-6 border-b border-slate-200">
        <h3 class="text-lg font-semibold text-slate-900">Peserta Terdaftar</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50">
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">No</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Nama Lengkap</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Email / No WA</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Tanggal Daftar</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Status Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peserta as $index => $p)
                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-slate-600">{{ $index + 1 }}</td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-slate-900">{{ $p->user->nama_lengkap ?? 'N/A' }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            <div>{{ $p->user->email ?? 'N/A' }}</div>
                            <div class="text-xs text-slate-400 mt-1">{{ $p->user->no_wa ?? '-' }}</div>
                        </td>
                        <td class="py-4 px-6 text-slate-600">
                            {{ $p->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $status = $p->status_pembayaran;
                                $badgeClass = match($status) {
                                    'settlement' => 'badge-success',
                                    'pending' => 'badge-warning',
                                    'cancel', 'expire' => 'badge-danger',
                                    default => 'badge-info',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ $status == 'settlement' ? 'Lunas' : ucfirst($status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-12">
                            <div class="flex flex-col items-center text-slate-400">
                                <i class="fas fa-users-slash text-5xl mb-4"></i>
                                <p class="font-medium">Belum ada siswa yang mendaftar pada jadwal ini</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
