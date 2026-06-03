@extends('layouts.panel')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 fade-in">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-500 mt-1">Selamat datang kembali, {{ Auth::user()->nama_lengkap }}!</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('admin.pengajar.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
                <i class="fas fa-plus mr-2"></i> Tambah Data
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Siswa -->
    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Siswa</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($totalSiswa) }}</p>
                <p class="text-sm text-green-600 mt-2">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +{{ $siswaBaru }} bulan ini
                </p>
            </div>
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pengajar -->
    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Pengajar</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($totalPengajar) }}</p>
                @if ($totalPengajar > 0)
                    <p class="text-sm text-green-600 mt-2">
                        <i class="fas fa-check-circle mr-1"></i>
                        Semua aktif
                    </p>
                @else
                    <p class="text-sm text-slate-400 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>
                        Belum ada pengajar
                    </p>
                @endif
            </div>
            <div class="w-14 h-14 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Kelas -->
    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Kelas</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">{{ number_format($totalKelas) }}</p>
                <p class="text-sm text-slate-500 mt-2">
                    <i class="fas fa-book mr-1"></i>
                    {{ \App\Models\MasterKelas::distinct('jenjang')->count('jenjang') }} jenjang
                </p>
            </div>
            <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-book-open text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Pendapatan Bulan Ini -->
    <div class="bg-white rounded-2xl shadow-sm p-6 card-hover border border-slate-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">Pendapatan Bulan Ini</p>
                <p class="text-3xl font-bold text-slate-900 mt-2">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
                @if ($pendapatanBulanIni > 0)
                    <p class="text-sm text-green-600 mt-2 font-medium">
                        <i class="fas fa-chart-line mr-1"></i>
                        Ada pemasukan
                    </p>
                @else
                    <p class="text-sm text-slate-400 mt-2">
                        <i class="fas fa-minus-circle mr-1"></i>
                        Belum ada pemasukan
                    </p>
                @endif
            </div>
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center">
                <i class="fas fa-wallet text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Analitik Admin -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-slate-900">Grafik Analitik Admin</h2>
            <p class="text-slate-500 text-sm mt-1">Analitik Pembayaran & Kelas</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mb-6">
        <!-- Line Chart - Pendapatan Bulanan -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                    Pendapatan Bulanan
                </h3>
                <span class="text-sm text-slate-500">Tahun {{ now()->year }}</span>
            </div>
            <div class="relative h-72">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Doughnut Chart - Status Pembayaran -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                    Status Pembayaran
                </h3>
                <span class="text-sm text-slate-500">Komposisi Status</span>
            </div>
            <div class="relative h-64">
                <canvas id="paymentStatusChart"></canvas>
            </div>
        </div>

        <!-- Bar Chart - Pendapatan per Kelas -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-slate-900">
                    <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
                    Pendapatan per Kelas
                </h3>
                <span class="text-sm text-slate-500">Top 10 Kelas</span>
            </div>
            <div class="relative h-64">
                <canvas id="revenueByClassChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terbaru -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-8">
    <div class="p-6 border-b border-slate-200">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-slate-900">Transaksi Terbaru</h2>
            <a href="{{ route('admin.pembayaran.index') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50">
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Invoice</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Siswa</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Kelas</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Tanggal</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Jumlah</th>
                    <th class="text-left py-4 px-6 font-semibold text-slate-700 text-sm">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksiTerbaru as $transaksi)
                    <tr class="border-t border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-4 px-6">
                            <span class="font-mono text-sm text-blue-600">{{ $transaksi->order_id }}</span>
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-medium text-slate-900">{{ $transaksi->user->nama_lengkap ?? '-' }}</span>
                        </td>
                        <td class="py-4 px-6 text-slate-600">{{ $transaksi->jadwalKelas->masterKelas->nama_kelas ?? '-' }}</td>
                        <td class="py-4 px-6 text-slate-600 text-sm">{{ \Carbon\Carbon::parse($transaksi->tanggal_bayar)->format('d M Y') }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            @php
                                $badgeClass = match($transaksi->status_pembayaran) {
                                    'settlement' => 'badge-success',
                                    'pending' => 'badge-warning',
                                    'cancel', 'expire', 'deny' => 'badge-danger',
                                    default => 'badge-info',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($transaksi->status_pembayaran) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8">
                            <i class="fas fa-inbox text-4xl text-slate-300 mb-3"></i>
                            <p class="text-slate-500">Belum ada transaksi</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('admin.pengajar.index') }}" class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm">Tambah Pengajar</p>
                <p class="text-xl font-bold mt-1">Kelola Guru</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-xl"></i>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.kelas.index') }}" class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm">Tambah Kelas</p>
                <p class="text-xl font-bold mt-1">Buat Kelas Baru</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-book text-xl"></i>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.jadwal.index') }}" class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm">Atur Jadwal</p>
                <p class="text-xl font-bold mt-1">Kelola Jadwal</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
        </div>
    </a>

    <a href="{{ route('admin.siswa.index') }}" class="bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl p-6 text-white card-hover">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-amber-100 text-sm">Data Siswa</p>
                <p class="text-xl font-bold mt-1">Lihat Semua</p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </div>
        </div>
    </a>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Format Rupiah untuk tooltip
    const formatRupiah = (value) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(value);
    };

    // Chart.js Global Configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b';

    // Data dari PHP
    const monthlyRevenueLabels = @json($monthlyRevenueLabels);
    const monthlyRevenueData = @json($monthlyRevenueData);
    const paymentStatusLabels = @json($paymentStatusLabels);
    const paymentStatusData = @json($paymentStatusData);
    const revenueByClassLabels = @json($revenueByClassLabels);
    const revenueByClassData = @json($revenueByClassData);

    // 1. Line Chart - Pendapatan Bulanan
    const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart');
    if (monthlyRevenueCtx) {
        new Chart(monthlyRevenueCtx, {
            type: 'line',
            data: {
                labels: monthlyRevenueLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: monthlyRevenueData,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: ' + formatRupiah(context.parsed.y);
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(0) + 'jt';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + 'rb';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    }

    // 2. Doughnut Chart - Status Pembayaran
    const paymentStatusCtx = document.getElementById('paymentStatusChart');
    if (paymentStatusCtx) {
        const totalTransactions = paymentStatusData.reduce((a, b) => a + b, 0);
        const hasData = totalTransactions > 0;

        new Chart(paymentStatusCtx, {
            type: 'doughnut',
            data: {
                labels: paymentStatusLabels,
                datasets: [{
                    data: paymentStatusData,
                    backgroundColor: [
                        '#f59e0b', // Pending - Amber
                        '#10b981', // Settlement - Green
                        '#ef4444', // Cancel - Red
                        '#8b5cf6'  // Expire - Purple
                    ],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const percentage = hasData ? ((value / totalTransactions) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // 3. Bar Chart - Pendapatan per Kelas
    const revenueByClassCtx = document.getElementById('revenueByClassChart');
    if (revenueByClassCtx && revenueByClassLabels.length > 0) {
        new Chart(revenueByClassCtx, {
            type: 'bar',
            data: {
                labels: revenueByClassLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenueByClassData,
                    backgroundColor: 'rgba(139, 92, 246, 0.8)',
                    borderColor: '#8b5cf6',
                    borderWidth: 0,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Pendapatan: ' + formatRupiah(context.parsed.x);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            color: '#e2e8f0',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return (value / 1000000).toFixed(0) + 'jt';
                                } else if (value >= 1000) {
                                    return (value / 1000).toFixed(0) + 'rb';
                                }
                                return value;
                            }
                        }
                    },
                    y: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        });
    } else if (revenueByClassCtx) {
        // Empty state untuk chart tanpa data
        const canvas = revenueByClassCtx;
        const parent = canvas.parentElement;
        parent.innerHTML = `
            <div class="flex items-center justify-center h-full text-center">
                <div>
                    <i class="fas fa-chart-bar text-4xl text-slate-300 mb-3"></i>
                    <p class="text-slate-500">Belum ada data pendapatan per kelas</p>
                    <p class="text-slate-400 text-sm mt-1">Data akan muncul setelah ada transaksi settlement</p>
                </div>
            </div>
        `;
    }
</script>
@endpush
@endsection