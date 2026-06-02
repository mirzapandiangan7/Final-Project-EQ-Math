<!doctype html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EQ - Math | Pendaftaran Kelas Matematika</title>
    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-gray-800 font-sans overflow-x-hidden">
    <nav class="bg-blue-600 text-white shadow-md fixed w-full top-0 z-50" data-aos="fade-down" data-aos-duration="1000">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="text-2xl font-bold tracking-wider hover:scale-105 transition-transform">EQ - Math</a>
            <div class="space-x-4">
                <a href="#tentang-kami" class="hover:text-blue-200 transition">Tentang Kami</a>
                <a href="#harga-kelas" class="hover:text-blue-200 transition">Pricing</a>
                <a href="{{ route('login') }}" class="bg-white text-blue-600 px-5 py-2 rounded-full font-semibold hover:bg-gray-100 hover:scale-105 active:scale-95 transition-all shadow-lg">
                    Masuk / Daftar
                </a>
            </div>
        </div>
    </nav>

    <div class="relative w-full overflow-hidden py-6 px-4 sm:px-8 lg:py-8 mt-16">
        <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('assets/background-index.webm') }}" type="video/webm" />
        </video>
        <header class="relative z-10 bg-white/85 hover:bg-white backdrop-blur-sm rounded-3xl shadow-2xl max-w-8xl mx-auto px-6 py-30 text-center transition-all duration-500 ease-in-out" data-aos="zoom-in" data-aos-duration="1200">
            <div class="py-20">
                <h1 class="text-5xl font-extrabold text-gray-900 mb-6" data-aos="fade-up" data-aos-delay="300">
                    Pahami Matematika dengan
                    <span class="text-blue-600">Lebih Mudah</span>
                </h1>
                <p class="text-lg text-gray-600 mb-10 max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="500">
                    Platform pendaftaran kelas matematika interaktif untuk jenjang SD, SMP, dan SMA. Pilih jadwalmu, temukan pengajar terbaik, dan tingkatkan nilaimu sekarang.
                </p>
                <div data-aos="fade-up" data-aos-delay="700">
                    <a href="{{ route('register') }}" class="inline-block bg-blue-600 text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-blue-700 hover:scale-105 hover:shadow-blue-500/50 hover:shadow-xl active:scale-95 shadow-lg transition-all duration-300">
                        Bergabung Sekarang
                    </a>
                </div>
            </div>
        </header>
    </div>

    <section id="tentang-kami" class="scroll-mt-24 py-20 bg-white pt-28 -mt-16 overflow-hidden">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div data-aos="fade-right" data-aos-duration="1000">
                    <h4 class="text-blue-600 font-bold mb-2 uppercase tracking-wide">
                        Mengenal EQ - Math
                    </h4>
                    <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-6">
                        Ubah Ketakutan Menjadi Kekuatan Berlogika
                    </h2>

                    <p class="text-gray-600 mb-4 leading-relaxed text-lg">
                        Sering merasa buntu dengan rumus aljabar atau pusing melihat soal kalkulus? Di <strong>EQ - Math</strong>, kami percaya tidak ada siswa yang tidak bisa matematika; yang ada hanyalah metode penyampaian yang belum tepat.
                    </p>
                    <p class="text-gray-600 mb-8 leading-relaxed">
                        Kami hadir sebagai platform edukasi interaktif yang mendobrak stigma bahwa matematika itu sulit. Dengan mengintegrasikan teknologi digital dan metode pengajaran personal, kami menghubungkan siswa SD, SMP, dan SMA dengan tutor-tutor ahli yang siap membimbing pemahaman konsep dari dasar hingga mahir.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 font-medium text-gray-800">
                        <div class="flex items-start group hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                🚀
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Kurikulum Adaptif</h5>
                                <p class="text-sm text-gray-500 font-normal mt-1">
                                    Materi terstruktur sesuai standar sekolah
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start group hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                👨‍🏫
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Tutor Terseleksi</h5>
                                <p class="text-sm text-gray-500 font-normal mt-1">
                                    Pengajar kompeten di bidangnya
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start group hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                ⏰
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Jadwal Fleksibel</h5>
                                <p class="text-sm text-gray-500 font-normal mt-1">
                                    Bebas atur waktu belajarmu sendiri
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start group hover:-translate-y-1 transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl mr-4 shadow-sm group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                💻
                            </div>
                            <div>
                                <h5 class="font-bold text-gray-900">Sistem Pintar</h5>
                                <p class="text-sm text-gray-500 font-normal mt-1">
                                    Pendaftaran & pembayaran terintegrasi
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mt-10 md:mt-0" data-aos="fade-left" data-aos-duration="1200">
                    <div class="absolute inset-0 bg-blue-600 rounded-3xl transform translate-x-4 translate-y-4 -z-10 opacity-20 animate-pulse">
                    </div>
                    <img src="{{ asset('assets/landing-page-img1.jpeg') }}" alt="Belajar Matematika Interaktif" class="rounded-3xl shadow-2xl w-full object-cover aspect-[4/3] border border-gray-100 hover:scale-[1.02] transition-transform duration-500" />
                </div>
            </div>
        </div>
    </section>

    <section id="harga-kelas" class="py-20 bg-slate-50 pt-28 -mt-16 scroll-mt-24">
        <div class="container mx-auto px-6 max-w-5xl text-center">
            <div data-aos="fade-up">
                <h4 class="text-blue-600 font-bold mb-2 uppercase tracking-wide">Investasi Pendidikan</h4>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-4">Pilih Paket Belajarmu</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mb-16">
                    Satu akses tak terbatas untuk semua materi, kelas, dan fitur interaktif kami.
                </p>
            </div>

            <div class="max-w-md mx-auto" data-aos="zoom-in-up" data-aos-duration="1000">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 hover:shadow-2xl hover:-translate-y-4 transition-all duration-500 group">
                    
                    <div class="px-6 py-8 sm:p-10 sm:pb-6 text-center">
                        <span class="inline-block px-4 py-1 rounded-full text-sm font-semibold text-blue-600 bg-blue-50 mb-4 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            Akses Fleksibel
                        </span>
                        <div class="flex justify-center items-baseline text-center">
                            <span class="text-gray-500 text-lg font-medium mr-2">Mulai dari</span>
                            <span class="text-5xl font-extrabold text-gray-900">Rp 150.000</span>
                        </div>
                        <span class="block text-sm font-medium text-gray-500 mt-2">/bulan atau per kelas</span>
                    </div>
                    
                    <div class="px-6 pt-6 pb-8 sm:p-10 sm:pt-6 bg-gray-50 text-left">
                        <ul class="space-y-4">
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-3 font-bold">✓</span>
                                <p class="text-base text-gray-700">Akses semua modul materi</p>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-3 font-bold">✓</span>
                                <p class="text-base text-gray-700">Latihan soal & kuis interaktif</p>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-3 font-bold">✓</span>
                                <p class="text-base text-gray-700">Grup diskusi komunitas</p>
                            </li>
                            <li class="flex items-start">
                                <span class="text-blue-500 mr-3 font-bold">✓</span>
                                <p class="text-base text-gray-700">Bantuan tugas sekolah</p>
                            </li>
                        </ul>
                        
                        <div class="mt-8">
                            <a href="{{ route('register') }}" class="w-full flex justify-center items-center px-6 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-blue-600 hover:bg-blue-700 hover:scale-105 hover:shadow-lg active:scale-95 transition-all duration-300 shadow-md">
                                Mulai Belajar Sekarang
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-white text-center py-10">
        <div class="container mx-auto px-6">
            <h3 class="text-2xl font-bold mb-4">EQ - Math</h3>
            <p class="text-gray-400 mb-6 max-w-md mx-auto">Solusi cerdas memahami matematika dengan cara yang menyenangkan dan interaktif.</p>
            <div class="flex justify-center space-x-6 mb-8">
                <a href="#" class="hover:text-blue-400 transition-colors text-xl"><i class="fab fa-instagram"></i></a>
                <a href="#" class="hover:text-blue-400 transition-colors text-xl"><i class="fab fa-facebook"></i></a>
                <a href="#" class="hover:text-blue-400 transition-colors text-xl"><i class="fab fa-twitter"></i></a>
            </div>
            <div class="border-t border-gray-700 pt-8">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} EQ - Math. Dibuat untuk ETS Pemrograman Web.</p>
            </div>
        </div>
    </footer>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                once: true,
                duration: 800,
                easing: 'ease-out-cubic',
                offset: 100
            });
        });
    </script>
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</body>

</html>