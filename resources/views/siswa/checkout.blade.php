@extends('layouts.panel')

@section('title', 'Pembayaran')

@section('content')
<!-- ==========================================================================
     PAGE HEADER
     ========================================================================== -->
<div class="mb-8 fade-in">
    <h1 class="text-3xl font-bold text-slate-900">Pembayaran</h1>
    <p class="text-slate-500 mt-1">Selesaikan pembayaran untuk mengaktifkan kelas</p>
</div>

<!-- ==========================================================================
     FLASH MESSAGES (Success/Error)
     ========================================================================== -->
@if(session('message'))
<div class="border-l-4 p-4 mb-4 rounded-lg {{ session('message_type') === 'error' ? 'bg-red-100 border-red-500 text-red-700' : 'bg-green-100 border-green-500 text-green-700' }} flex items-center">
    <i class="fas {{ session('message_type') === 'error' ? 'fa-exclamation-circle' : 'fa-check-circle' }} mr-3"></i>
    <span>{{ session('message') }}</span>
</div>
@endif

<!-- ==========================================================================
     NEW REGISTRATION SECTION
     ========================================================================== -->
@if ($kelasInfo)
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Pendaftaran Kelas Baru</h2>
                <p class="text-slate-500">Selesaikan pembayaran untuk mengaktifkan kelas</p>
            </div>
        </div>

        <div class="border border-slate-200 rounded-xl p-6">
            <!-- Detail Kelas -->
            <div class="flex items-center space-x-4 mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white">
                    <i class="fas fa-calculator text-2xl"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-900">{{ $kelasInfo->nama_kelas }}</h3>
                    <p class="text-slate-500">{{ $kelasInfo->jenjang }} - Paket Bulanan</p>
                </div>
            </div>

            <!-- Rincian Biaya -->
            <div class="bg-slate-50 rounded-xl p-4 mb-6">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-slate-500">Harga kelas</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($kelasInfo->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-slate-500">Biaya admin</span>
                        <span class="font-semibold text-slate-900">Rp 2.500</span>
                    </div>
                    <div class="flex justify-between pt-3 border-t border-slate-200">
                        <span class="font-bold text-slate-900">Total Pembayaran</span>
                        <span class="font-bold text-blue-600 text-xl">Rp {{ number_format($kelasInfo->harga + 2500, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <h4 class="font-semibold text-slate-900 mb-3">Pilih Jadwal</h4>

            @if ($jadwalList->isEmpty())
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                    <p class="text-amber-700">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Belum ada jadwal tersedia untuk kelas ini.
                    </p>
                </div>
            @else
                <!-- Pilihan Jadwal (Radio) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                    @foreach ($jadwalList as $jadwal)
                        <label class="border-2 border-slate-200 rounded-xl p-4 cursor-pointer hover:border-blue-600 transition has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50">
                            <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" required form="form-daftar-baru" class="sr-only">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $jadwal->hari }}</p>
                                    <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium text-blue-600">{{ $jadwal->masterPengajar->nama_pengajar ?? 'TBD' }}</p>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <!-- Form Pendaftaran Baru (AJAX) -->
                <form id="form-daftar-baru" onsubmit="handlePayment(event, this)">
                    @csrf
                    <input type="hidden" name="jadwal_id" id="selected_jadwal_id">
                    <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl hover:bg-blue-700 transition font-semibold text-lg">
                        <i class="fas fa-lock mr-2"></i> Lanjutkan Pembayaran
                    </button>
                </form>

                <a href="{{ url()->previous() }}" class="mt-3 w-full flex items-center justify-center border-2 border-slate-200 text-slate-600 bg-white py-4 rounded-xl hover:bg-slate-50 transition font-semibold text-lg">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            @endif
        </div>
    </div>
@endif

<!-- ==========================================================================
     PENDING PAYMENTS SECTION
     ========================================================================== -->
@if ($pembayaranPending->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-8 border border-slate-200">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Tagihan Belum Dibayar</h2>
                <p class="text-slate-500">Selesaikan pembayaran yang tertunda</p>
            </div>
            <span class="badge bg-amber-100 text-amber-700 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                <i class="fas fa-clock mr-1"></i> {{ $pembayaranPending->count() }} tagihan
            </span>
        </div>

        <div class="space-y-4">
            @foreach ($pembayaranPending as $tagihan)
                <div class="border border-amber-200 rounded-xl p-5 bg-amber-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center">
                                <i class="fas fa-receipt text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900">{{ $tagihan->jadwalKelas->masterKelas->nama_kelas ?? '-' }}</h3>
                                <p class="text-sm text-slate-500">{{ $tagihan->order_id }}</p>
                            </div>
                        </div>
                        <div class="text-left md:text-right">
                            <p class="text-2xl font-bold text-amber-600">Rp {{ number_format($tagihan->jumlah_bayar, 0, ',', '.') }}</p>
                            <p class="text-sm text-slate-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($tagihan->created_at)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-amber-200">
                        <p class="text-sm text-amber-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pembayaran akan segera diproses setelah dikonfirmasi
                        </p>
                        <div class="flex items-center space-x-3">
                            <!-- Tombol Batalkan Transaksi -->
                            <form action="{{ route('siswa.payment.cancel', $tagihan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran kelas ini?')">
                                @csrf
                                <button type="submit" class="px-6 py-2.5 border-2 border-slate-300 text-slate-600 rounded-xl hover:bg-slate-100 transition font-medium">
                                    Batalkan
                                </button>
                            </form>
                            <!-- Tombol Bayar (Lanjut Snap) -->
                            <form onsubmit="handlePayment(event, this)">
                                @csrf
                                <input type="hidden" name="jadwal_id" value="{{ $tagihan->jadwal_id }}">
                                <button type="submit" class="px-6 py-2.5 bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition font-medium">
                                    <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

<!-- ==========================================================================
     MIDTRANS SNAP SCRIPTS
     ========================================================================== -->
<script type="text/javascript"
    src="{{ env('MIDTRANS_IS_PRODUCTION', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
    data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
</script>

<script type="text/javascript">
    /**
     * Menangani proses pembayaran via AJAX untuk menyimpan data PENDING terlebih dahulu.
     */
    function handlePayment(event, form) {
        event.preventDefault();

        // 1. Ambil jadwal_id dari form yang disubmit
        let jadwalId;
        if (form.id === 'form-daftar-baru') {
            const radioSelected = document.querySelector('input[name="jadwal_id"]:checked');
            if (!radioSelected) {
                alert("⚠️ Mohon pilih Jadwal Kelas terlebih dahulu!");
                return;
            }
            jadwalId = radioSelected.value;
        } else {
            jadwalId = form.querySelector('input[name="jadwal_id"]').value;
        }

        // 2. Efek loading pada tombol
        const btn = form.querySelector('button[type="submit"]');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';

        // 3. Panggil Backend (AJAX)
        fetch("{{ url('siswa/payment/process') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ jadwal_id: jadwalId })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = originalText;

            if (data.status === 'success') {
                // 4. Buka Pop-up Midtrans Snap menggunakan token dari backend
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        alert("Pembayaran Berhasil!");
                        window.location.href = "{{ route('siswa.dashboard') }}";
                    },
                    onPending: function(result) {
                        alert("Silakan selesaikan pembayaran Anda sesuai instruksi Midtrans.");
                        window.location.href = "{{ route('siswa.dashboard') }}";
                    },
                    onError: function(result) {
                        alert("Pembayaran Gagal.");
                        location.reload();
                    },
                    onClose: function() {
                        alert("Anda menutup jendela pembayaran. Tagihan tersimpan aman di Dashboard.");
                        window.location.href = "{{ route('siswa.dashboard') }}";
                    }
                });
            } else {
                alert(data.message || "Terjadi kesalahan.");
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = originalText;
            console.error('Error:', error);
            alert("Gagal menghubungi server.");
        });
    }
</script>
@endsection
{{-- 
     CATATAN TROUBLESHOOTING:
     Kesalahan sebelumnya adalah terdapat dua tag @endsection di akhir file, 
     sehingga Laravel mencoba menutup section yang tidak pernah dibuka.
--}}
