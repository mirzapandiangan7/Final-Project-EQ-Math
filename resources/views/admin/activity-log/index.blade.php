@extends('layouts.panel')

@section('title', 'Activity Log')

@section('content')
<div class="fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Activity Log</h1>
            <p class="text-slate-600">Jejak audit seluruh aktivitas di sistem.</p>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Waktu</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Aktor</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Deskripsi</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Modul/Target</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Detail Perubahan</th>
                        <th class="px-6 py-4 text-sm font-semibold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 text-sm text-slate-600">
                                <div class="font-medium text-slate-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs">{{ $log->created_at->format('H:i:s') }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($log->causer)
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-600 text-xs font-bold">
                                            {{ strtoupper(substr($log->causer->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-slate-900">{{ $log->causer->nama_lengkap }}</div>
                                            <div class="text-xs text-slate-500 capitalize">{{ $log->causer->role }}</div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-slate-400 italic">System / Guest</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $badgeClass = 'badge-info';
                                    if(Str::contains($log->description, 'created')) $badgeClass = 'badge-success';
                                    elseif(Str::contains($log->description, 'updated')) $badgeClass = 'badge-info';
                                    elseif(Str::contains($log->description, 'deleted')) $badgeClass = 'badge-danger';
                                @endphp
                                <span class="badge {{ $badgeClass }} capitalize">
                                    {{ $log->description }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-medium text-slate-900">{{ class_basename($log->subject_type) }}</div>
                                <div class="text-xs text-slate-500">ID: {{ $log->subject_id }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($log->changes())
                                    <button type="button" 
                                            onclick="showDetail({{ $log->id }})"
                                            class="text-blue-600 hover:text-blue-800 font-medium transition-smooth">
                                        Lihat Detail
                                    </button>
                                    <div id="detail-{{ $log->id }}" class="hidden">
                                        {{ json_encode($log->changes()) }}
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.activity-log.show', $log->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">Lihat</a>
                                    <form action="{{ route('admin.activity-log.destroy', $log->id) }}" method="POST" onsubmit="return confirm('Hapus log aktivitas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-history text-4xl mb-3 opacity-20"></i>
                                    <p>Belum ada aktivitas yang tercatat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-200 bg-slate-50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function showDetail(id) {
        const detail = document.getElementById('detail-' + id).innerText;
        const data = JSON.parse(detail);
        
        let html = '<div class="text-left overflow-x-auto max-h-96 text-sm">';
        
        if (data.attributes) {
            html += '<h4 class="font-bold mb-2 text-slate-700">Data Baru / Saat Ini:</h4>';
            html += '<table class="w-full mb-4 border border-slate-200 rounded">';
            for (const [key, value] of Object.entries(data.attributes)) {
                html += `<tr><td class="p-2 border bg-slate-50 font-semibold w-1/3">${key}</td><td class="p-2 border">${JSON.stringify(value)}</td></tr>`;
            }
            html += '</table>';
        }
        
        if (data.old) {
            html += '<h4 class="font-bold mb-2 text-slate-700">Data Sebelumnya:</h4>';
            html += '<table class="w-full border border-slate-200 rounded">';
            for (const [key, value] of Object.entries(data.old)) {
                html += `<tr><td class="p-2 border bg-slate-50 font-semibold w-1/3">${key}</td><td class="p-2 border text-red-600">${JSON.stringify(value)}</td></tr>`;
            }
            html += '</table>';
        }
        
        html += '</div>';

        Swal.fire({
            title: 'Detail Perubahan',
            html: html,
            width: '600px',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#3b82f6'
        });
    }
</script>
@endsection
