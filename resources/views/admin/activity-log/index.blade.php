@extends('layouts.panel')

@section('title', 'Activity Log')

@section('content')
<div class="fade-in">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Activity Log</h1>
            <p class="text-slate-600">Jejak audit seluruh aktivitas di sistem.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.activity-log.index') }}" method="GET" id="searchForm" class="flex flex-col md:flex-row items-center gap-3">
                <!-- FITUR PENCARIAN & AUTOCOMPLETE -->
                <div class="relative group">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                           placeholder="Cari nama user..." autocomplete="off"
                           class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full md:w-64 p-2 pl-8">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400 text-xs"></i>
                    </div>

                    <!-- DROPDOWN AUTOCOMPLETE -->
                    <div id="autocompleteResults" 
                         class="absolute z-50 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-lg hidden max-h-60 overflow-y-auto">
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <label for="role" class="text-sm font-medium text-slate-700 whitespace-nowrap">Filter Role:</label>
                    <select name="role" id="role" onchange="this.form.submit()" 
                            class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                </div>

                @if(request('search') || request('role'))
                    <a href="{{ route('admin.activity-log.index') }}" class="text-xs text-red-600 hover:underline">Reset</a>
                @endif
            </form>
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
        // Tampilkan loading sebentar
        Swal.fire({
            title: 'Memuat data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Ambil data via AJAX menggunakan Fetch API
        fetch(`/admin/activity-log/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                const data = res.data;
                const properties = data.properties;

                let html = `
                    <div class="text-left text-sm">
                        <div class="grid grid-cols-3 gap-2 mb-4 p-3 bg-slate-50 rounded-lg border border-slate-200">
                            <div class="text-slate-500 font-semibold">Waktu:</div>
                            <div class="col-span-2 text-slate-800">${data.created_at}</div>
                            <div class="text-slate-500 font-semibold">Aktor:</div>
                            <div class="col-span-2 text-slate-800">${data.actor}</div>
                            <div class="text-slate-500 font-semibold">Deskripsi:</div>
                            <div class="col-span-2 text-slate-800 capitalize">${data.description}</div>
                            <div class="text-slate-500 font-semibold">Target:</div>
                            <div class="col-span-2 text-slate-800">${data.subject}</div>
                        </div>
                `;

                if (properties) {
                    html += '<h4 class="font-bold mb-2 text-slate-700">Detail JSON:</h4>';
                    html += `
                        <div class="bg-slate-900 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-green-400 font-mono text-xs"><code>${JSON.stringify(properties, null, 4)}</code></pre>
                        </div>
                    `;
                } else {
                    html += '<p class="text-slate-400 italic">Tidak ada detail perubahan tersimpan.</p>';
                }

                html += '</div>';

                Swal.fire({
                    title: 'Audit Log Detail',
                    html: html,
                    width: '650px',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#3b82f6'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Gagal memuat data detail log.', 'error');
        });
    }

    // FITUR AUTOCOMPLETE
    const searchInput = document.getElementById('searchInput');
    const autocompleteResults = document.getElementById('autocompleteResults');
    const searchForm = document.getElementById('searchForm');
    let debounceTimer;

    searchInput.addEventListener('input', function() {
        const query = this.value;

        clearTimeout(debounceTimer);
        
        if (query.length < 1) { // Mulai dari 1 karakter agar lebih responsif
            autocompleteResults.classList.add('hidden');
            return;
        }

        debounceTimer = setTimeout(() => {
            // Menggunakan route helper agar URL selalu benar (termasuk jika di subdirectory)
            const url = `{{ route('admin.activity-log.autocomplete') }}?q=${encodeURIComponent(query)}`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        let html = '';
                        data.forEach(user => {
                            html += `
                                <div class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-sm text-slate-700 border-b border-slate-100 last:border-0"
                                     onclick="selectUser('${user.nama_lengkap}')">
                                    <i class="fas fa-user text-slate-400 mr-2 text-xs"></i>
                                    ${user.nama_lengkap}
                                </div>
                            `;
                        });
                        autocompleteResults.innerHTML = html;
                        autocompleteResults.classList.remove('hidden');
                    } else {
                        autocompleteResults.classList.add('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error fetching autocomplete:', error);
                });
        }, 300);
    });

    // Pilih user dari dropdown
    window.selectUser = function(name) {
        searchInput.value = name;
        autocompleteResults.classList.add('hidden');
        searchForm.submit();
    };

    // Sembunyikan dropdown saat klik di luar
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
            autocompleteResults.classList.add('hidden');
        }
    });
</script>
@endsection
