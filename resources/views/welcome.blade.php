<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TemanCerita Smansus</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Vite for Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Navbar -->
    <nav class="w-full bg-white shadow-sm px-6 py-4 fixed top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-sky-600 font-bold text-xl tracking-tight">TemanCerita Smansus</div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-600">
                <a href="#" class="text-gray-900 font-semibold border-b-2 border-sky-600">Home</a>
                <a href="#" class="hover:text-sky-600 transition">Features</a>
                <a href="#" class="hover:text-sky-600 transition">About Us</a>
            </div>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-sky-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-sky-700 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 bg-sky-600 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-sky-700 transition">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Content Wrapper with top padding for navbar -->
    <div class="pt-20">
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-sky-600 leading-tight mb-6">Mendukung Langkah Anda Menuju Kesejahteraan</h1>
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    Di TemanCerita Smansus, kami percaya bahwa setiap individu layak mendapatkan ruang aman untuk tumbuh, sembuh, dan menemukan kedamaian batin melalui bimbingan profesional yang empatik.
                </p>
                <a href="#" class="inline-block px-6 py-3 bg-sky-600 text-white font-semibold rounded-md shadow hover:bg-sky-700 transition">Pelajari Lebih Lanjut</a>
            </div>
            <div class="relative">
                <div class="w-full h-80 md:h-[450px] bg-gray-200 rounded-3xl shadow-inner"></div>
                <div class="absolute bottom-6 -left-6 bg-sky-100 text-sky-700 px-4 py-2 rounded-lg shadow-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg>
                    Terpercaya & Berlisensi
                </div>
            </div>
        </section>

        <!-- Cerita Kami -->
        <section class="bg-white py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="grid grid-cols-2 gap-4">
                    <div class="h-64 bg-gray-100 rounded-2xl shadow-sm"></div>
                    <div class="h-64 bg-gray-100 rounded-2xl shadow-sm mt-8"></div>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 bg-sky-100 text-sky-700 font-semibold text-xs rounded-full mb-4">Cerita Kami</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-sky-600 mb-6">Awal Mula Sebuah Perjalanan</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">
                        TemanCerita Smansus didirikan dari sebuah visi sederhana: menciptakan jembatan antara kebutuhan kesehatan mental yang mendesak dengan layanan profesional yang terjangkau dan mudah diakses.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Kami menyadari bahwa langkah pertama mencari bantuan seringkali adalah yang tersulit. Oleh karena itu, kami membangun platform yang tidak hanya mengedepankan keahlian klinis, tetapi juga kehangatan dan kemudahan akses bagi seluruh lapisan masyarakat.
                    </p>
                </div>
            </div>
        </section>

        <!-- Visi & Nilai -->
        <section class="bg-gray-50 py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-sky-600 mb-12">Visi Kami & Nilai Utama</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Empati -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 mx-auto bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-sky-600 mb-3">Empati</h3>
                        <p class="text-gray-500 text-sm">Kami mendengarkan tanpa menghakimi, memastikan setiap suara didengar dan setiap perasaan divalidasi dengan sepenuh hati.</p>
                    </div>
                    <!-- Privasi -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 mx-auto bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-sky-600 mb-3">Privasi</h3>
                        <p class="text-gray-500 text-sm">Kerahasiaan Anda adalah prioritas tertinggi kami. Ruang aman yang kami sediakan dilindungi oleh prosedur keamanan ketat.</p>
                    </div>
                    <!-- Solusi -->
                    <div class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-md transition">
                        <div class="w-14 h-14 mx-auto bg-sky-100 text-sky-600 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 103.636 5.05l-.707.707a1 1 0 001.414 1.414l.707-.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path></svg>
                        </div>
                        <h3 class="text-xl font-semibold text-sky-600 mb-3">Solusi</h3>
                        <p class="text-gray-500 text-sm">Kami berfokus pada hasil yang terukur dan aplikatif membantu Anda menemukan strategi yang tepat untuk menghadapi tantangan hidup.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tim Profesional -->
        <section class="bg-gray-100 py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-sky-600 mb-4">Tim Profesional Kami</h2>
                <p class="text-gray-500 mb-12">Ahli yang berdedikasi untuk membantu kesehatan mental Anda</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Member 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm p-4">
                        <div class="w-full h-48 bg-sky-100 rounded-xl mb-4"></div>
                        <h3 class="font-semibold text-sky-700 text-sm">Dr. Sarah Wijaya, M.Psi.</h3>
                        <p class="text-xs text-gray-500 mb-3">Psikolog Klinis Dewasa</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                        </div>
                    </div>
                    <!-- Member 2 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm p-4">
                        <div class="w-full h-48 bg-sky-100 rounded-xl mb-4"></div>
                        <h3 class="font-semibold text-sky-700 text-sm">Budi Santoso, M.Psi.</h3>
                        <p class="text-xs text-gray-500 mb-3">Konselor Pernikahan</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                        </div>
                    </div>
                    <!-- Member 3 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm p-4">
                        <div class="w-full h-48 bg-sky-100 rounded-xl mb-4"></div>
                        <h3 class="font-semibold text-sky-700 text-sm">Anita Putri, S.Psi., M.A.</h3>
                        <p class="text-xs text-gray-500 mb-3">Psikolog Anak & Remaja</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                        </div>
                    </div>
                    <!-- Member 4 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm p-4">
                        <div class="w-full h-48 bg-sky-100 rounded-xl mb-4"></div>
                        <h3 class="font-semibold text-sky-700 text-sm">Prof. Dr. Hendra Lim</h3>
                        <p class="text-xs text-gray-500 mb-3">Konselor Senior</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Tengah (Ingin Berdiskusi) -->
        <section class="bg-sky-700 py-16">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-white mb-4">Ingin Berdiskusi Lebih Lanjut?</h2>
                <p class="text-sky-100 mb-8">Kami siap mendampingi setiap langkah Anda. Mulailah perjalanan kesehatan mental Anda hari ini dengan sesi konsultasi privat dan profesional.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('register') }}" class="px-8 py-3 bg-white text-sky-700 font-semibold rounded-md shadow hover:bg-gray-100 transition">Book Session Sekarang</a>
                    <a href="#" class="px-8 py-3 border border-white text-white font-semibold rounded-md hover:bg-sky-600 transition">Hubungi Support</a>
                </div>
            </div>
        </section>

        <!-- Fitur Unggulan -->
        <section class="bg-white py-16 md:py-24">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <span class="inline-block px-3 py-1 bg-sky-100 text-sky-700 font-semibold text-xs rounded-full mb-4">FITUR UNGGULAN</span>
                    <h2 class="text-3xl font-bold text-sky-600 mb-4">Platform konseling terintegrasi</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Dirancang untuk mendukung pertumbuhan emosional siswa, efisiensi konselor, dan transparansi data sekolah dalam satu ekosistem yang aman.</p>
                </div>

                <!-- Untuk Siswa -->
                <div class="mb-16">
                    <div class="flex items-center gap-4 mb-8">
                        <hr class="flex-1 border-gray-200">
                        <span class="text-sky-600 font-semibold text-sm">Untuk Siswa</span>
                        <hr class="flex-1 border-gray-200">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="col-span-1 bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative">
                            <div class="w-10 h-10 bg-sky-50 rounded-full flex items-center justify-center text-sky-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Analisis Bakat</h3>
                            <p class="text-sm text-gray-500 mb-4">Temukan potensi tersembunyi Anda melalui kuesioner bakat yang dikembangkan oleh psikolog profesional.</p>
                        </div>
                        <div class="col-span-1 md:col-span-1 bg-gray-100 rounded-2xl flex items-center justify-center min-h-[200px]">
                            <!-- Radar chart placeholder -->
                            <div class="w-32 h-32 opacity-50 bg-sky-200" style="clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);"></div>
                        </div>
                        <div class="col-span-1 bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative">
                            <div class="w-10 h-10 bg-sky-50 rounded-full flex items-center justify-center text-sky-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Booking Konseling</h3>
                            <p class="text-sm text-gray-500 mb-4">Pilih waktu dan konselor favorit Anda tanpa antrean. Jadwalkan sesi konsultasi kapan saja.</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="col-span-1 bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative">
                            <div class="w-10 h-10 bg-sky-50 rounded-full flex items-center justify-center text-sky-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Jurnal Wellness</h3>
                            <p class="text-sm text-gray-500 mb-4">Pantau kondisi emosional Anda dengan jurnal harian interaktif. Dapatkan rekomendasi aktivitas.</p>
                        </div>
                        <div class="col-span-1 md:col-span-2 bg-sky-700 rounded-2xl p-8 flex flex-col md:flex-row items-center justify-between">
                            <div class="mb-4 md:mb-0">
                                <h3 class="font-bold text-white text-xl mb-2">Siap Mengeksplorasi Diri Lebih Dalam?</h3>
                                <p class="text-sky-100 text-sm">Mulai perjalanan kesehatan mental Anda bersama TemanCerita Smansus.</p>
                            </div>
                            <a href="#" class="px-6 py-2 bg-white text-sky-700 font-semibold rounded shadow hover:bg-gray-50 transition shrink-0">Coba Sekarang</a>
                        </div>
                    </div>
                </div>

                <!-- Untuk Konselor -->
                <div class="mb-16">
                    <div class="flex items-center gap-4 mb-8">
                        <hr class="flex-1 border-gray-200">
                        <span class="text-sky-600 font-semibold text-sm">Untuk Konselor</span>
                        <hr class="flex-1 border-gray-200">
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded mb-3">Efisiensi Kinerja</span>
                            <h3 class="font-bold text-gray-800 text-2xl mb-4">Manajemen Jadwal Otomatis</h3>
                            <p class="text-gray-500 text-sm mb-6">Lupakan pencatatan manual yang melelahkan. Sistem cerdas kami mengsinkronisasi jadwal konseling, mengirimkan pengingat otomatis kepada siswa, dan mengatur ulang slot kosong secara real-time.</p>
                            <ul class="space-y-3 text-sm text-gray-600">
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Sinkronisasi Google Calendar & Outlook</li>
                                <li class="flex items-center gap-2"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Notifikasi WhatsApp & Email Otomatis</li>
                            </ul>
                        </div>
                        <div class="bg-gray-100 rounded-3xl p-6 h-80 flex items-center justify-center border border-gray-200">
                            <!-- Dashboard Mockup Placeholder -->
                            <div class="w-full h-full bg-white rounded-xl shadow border border-gray-200 p-4 opacity-50 relative">
                                <div class="w-full h-6 bg-gray-100 rounded mb-4"></div>
                                <div class="grid grid-cols-4 gap-2 h-full">
                                    <div class="bg-gray-50 border border-gray-100 rounded"></div>
                                    <div class="bg-sky-50 border border-sky-100 rounded"></div>
                                    <div class="bg-gray-50 border border-gray-100 rounded"></div>
                                    <div class="bg-sky-50 border border-sky-100 rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mt-12">
                        <div class="bg-gray-100 rounded-3xl p-6 h-64 flex items-center justify-center border border-gray-200 order-2 lg:order-1">
                             <!-- Chart Placeholder -->
                             <div class="w-full h-full flex items-end justify-around p-4 opacity-50">
                                <div class="w-1/6 bg-sky-300 h-1/4 rounded-t"></div>
                                <div class="w-1/6 bg-sky-400 h-1/2 rounded-t"></div>
                                <div class="w-1/6 bg-sky-500 h-3/4 rounded-t"></div>
                                <div class="w-1/6 bg-sky-600 h-full rounded-t"></div>
                             </div>
                        </div>
                        <div class="order-1 lg:order-2">
                            <span class="inline-block px-2 py-1 bg-sky-100 text-sky-700 text-xs font-semibold rounded mb-3">Data Driven Support</span>
                            <h3 class="font-bold text-gray-800 text-2xl mb-4">Dashboard Insights</h3>
                            <p class="text-gray-500 text-sm mb-6">Dapatkan gambaran menyeluruh tentang kesejahteraan kolektif siswa. Deteksi dini tren penurunan kesehatan emosional, tingkat kepuasan sesi, dan identifikasi siswa yang membutuhkan perhatian lebih.</p>
                            <div class="flex gap-4">
                                <div class="bg-gray-50 rounded-lg p-4 flex-1">
                                    <div class="font-bold text-sky-600 text-xl">92%</div>
                                    <div class="text-xs text-gray-500">Akurasi Deteksi Dini</div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 flex-1">
                                    <div class="font-bold text-green-600 text-xl">15+</div>
                                    <div class="text-xs text-gray-500">Indikator Psikologis</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Solusi Sekolah -->
                <div>
                    <div class="flex items-center gap-4 mb-8">
                        <hr class="flex-1 border-gray-200">
                        <span class="text-sky-600 font-semibold text-sm">Solusi Strategis untuk Sekolah</span>
                        <hr class="flex-1 border-gray-200">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative">
                            <div class="w-10 h-10 bg-sky-50 rounded flex items-center justify-center text-sky-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Laporan Berkala</h3>
                            <p class="text-sm text-gray-500">Laporan komprehensif bulanan dan semesteran yang siap pakai untuk keperluan akreditasi dan evaluasi program sekolah.</p>
                        </div>
                        <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6 relative">
                            <div class="w-10 h-10 bg-green-50 rounded flex items-center justify-center text-green-600 mb-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Data Analytics</h3>
                            <p class="text-sm text-gray-500">Analitik prediktif untuk membantu manajemen sekolah mengambil kebijakan berbasis data guna menunjang iklim belajar-mengajar.</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom CTA -->
                <div class="mt-20 text-center">
                    <p class="text-sm font-semibold text-gray-500 mb-2">Siap untuk memulai?</p>
                    <p class="text-gray-600 mb-6">Bergabunglah dengan ratusan sekolah yang telah memodernisasi layanan konseling mereka bersama TemanCerita Smansus.</p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-sky-600 text-white font-semibold rounded shadow hover:bg-sky-700 transition">Daftar Sekarang</a>
                        <a href="#" class="px-6 py-2 border border-sky-600 text-sky-600 font-semibold rounded hover:bg-sky-50 transition">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-200 py-12">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-1">
                    <div class="text-sky-600 font-bold text-xl tracking-tight mb-4">TemanCerita Smansus</div>
                    <p class="text-xs text-gray-500 mb-6 leading-relaxed">Membangun generasi tangguh melalui dukungan emosional yang cerdas dan terukur.</p>
                    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} TemanCerita Smansus. All rights reserved.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Layanan</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">Konseling Individu</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Terapi Pasangan</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Psikologi Anak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Perusahaan</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">About Us</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Counselor Portal</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-4 text-sm">Legal</h4>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
