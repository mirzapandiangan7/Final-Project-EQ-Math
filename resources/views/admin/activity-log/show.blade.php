@extends('layouts.panel')

@section('title', 'Activity Log Detail')

@section('content')
<div class="fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Detail Activity Log</h1>
            <p class="text-slate-600">Informasi lengkap dari rekaman aktivitas.</p>
        </div>
        <a href="{{ route('admin.activity-log.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition">
            Kembali ke Activity Log
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <h2 class="font-semibold text-slate-900">Aktor</h2>
                @if($log->causer)
                    <p class="text-slate-600">{{ $log->causer->nama_lengkap }} ({{ ucfirst($log->causer->role) }})</p>
                    <p class="text-slate-500 text-sm">{{ $log->causer->email }}</p>
                @else
                    <p class="text-slate-500 italic">System / Guest</p>
                @endif
            </div>
            <div>
                <h2 class="font-semibold text-slate-900">Waktu</h2>
                <p class="text-slate-600">{{ $log->created_at->format('d M Y H:i:s') }}</p>
            </div>
            <div>
                <h2 class="font-semibold text-slate-900">Deskripsi</h2>
                <p class="text-slate-600 capitalize">{{ $log->description }}</p>
            </div>
            <div>
                <h2 class="font-semibold text-slate-900">Modul / Target</h2>
                <p class="text-slate-600">{{ class_basename($log->subject_type ?? 'N/A') }}</p>
                <p class="text-slate-500 text-sm">ID: {{ $log->subject_id ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <h2 class="font-semibold text-slate-900 mb-3">Detail Perubahan</h2>
            @if($log->changes())
                <div class="space-y-4">
                    @if(isset($log->changes()['attributes']))
                        <div class="rounded-xl border border-slate-200 p-4 bg-slate-50">
                            <h3 class="font-semibold mb-2">Data Baru / Saat Ini</h3>
                            <table class="w-full text-sm">
                                @foreach($log->changes()['attributes'] as $key => $value)
                                    <tr>
                                        <td class="py-2 pr-3 font-semibold text-slate-700 w-32">{{ $key }}</td>
                                        <td class="py-2 text-slate-600">{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                    @if(isset($log->changes()['old']))
                        <div class="rounded-xl border border-slate-200 p-4 bg-white">
                            <h3 class="font-semibold mb-2">Data Sebelumnya</h3>
                            <table class="w-full text-sm">
                                @foreach($log->changes()['old'] as $key => $value)
                                    <tr>
                                        <td class="py-2 pr-3 font-semibold text-slate-700 w-32">{{ $key }}</td>
                                        <td class="py-2 text-slate-600">{{ is_array($value) ? json_encode($value) : $value }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-slate-500">Tidak ada detail perubahan yang tersimpan.</p>
            @endif
        </div>
    </div>
</div>
@endsection
