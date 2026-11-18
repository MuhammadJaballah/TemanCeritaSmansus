<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TemanCerita Smansus</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Vite for Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-sky-200 selection:text-sky-900">
    <!-- Navbar -->
    <nav class="w-full bg-white/80 backdrop-blur-md shadow-sm px-6 py-4 fixed top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo-smanbinsuskotadumai.png') }}" class="w-8 h-8 object-contain" alt="Logo Smansus">
                <div class="text-[#0ea5e9] font-bold text-xl tracking-tight">TemanCerita Smansus</div>
            </div>
            <div class="hidden md:flex space-x-8 text-sm font-medium text-gray-500">
                <a href="{{ route('home') }}#home" class="hover:text-gray-900 transition border-b-2 border-transparent hover:border-sky-500 pb-1">Home</a>
                <a href="{{ route('home') }}#features" class="hover:text-gray-900 transition border-b-2 border-transparent hover:border-sky-500 pb-1">Features</a>
                <a href="{{ route('about') }}" class="hover:text-gray-900 transition border-b-2 border-transparent hover:border-sky-500 pb-1">About Us</a>
            </div>
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-[#0284c7] hover:bg-[#0369a1] text-white text-sm font-semibold rounded-lg shadow-sm transition-all focus:ring-4 focus:ring-sky-100">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-[#0284c7] hover:bg-[#0369a1] text-white text-sm font-semibold rounded-lg shadow-sm transition-all focus:ring-4 focus:ring-sky-100">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24">
        <!-- HOME SECTION -->
        <section id="home" class="max-w-7xl mx-auto px-6 py-12 md:py-20">
            <!-- Hero -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-24">
                <div class="pr-0 lg:pr-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-sky-50 text-sky-600 rounded-full text-xs font-semibold mb-6 border border-sky-100">
                        <span>> Selamat Datang di TemanCerita Smansus</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-[54px] font-bold text-gray-900 leading-[1.15] mb-6 tracking-tight">
                        Temukan <br>Ketenangan, <br><span class="text-[#0284c7]">Bangun Masa Depan</span>
                    </h1>
                    <p class="text-gray-500 text-lg mb-10 leading-relaxed max-w-lg">
                        Sistem bimbingan konseling sekolah yang aman, rahasia, dan mendukung pertumbuhan mental siswa demi kesuksesan akademik dan personal.
                    </p>
                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#features" class="px-7 py-3.5 bg-[#0284c7] hover:bg-[#0369a1] text-white font-semibold rounded-xl shadow-md shadow-sky-200 transition-all text-sm">Mulai Sekarang</a>
                        <a href="#" class="px-7 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lihat Demo
                        </a>
                    </div>
                </div>
                <div class="relative w-full h-[500px]">
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-sky-50 rounded-[2rem] shadow-sm border border-gray-100/50"></div>
                    <div class="absolute -top-10 -right-10 w-40 h-40 bg-sky-100/50 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-green-100/50 rounded-full blur-3xl"></div>
                </div>
            </div>

            <!-- Mengapa TemanCerita Smansus? -->
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa TemanCerita Smansus?</h2>
                <p class="text-gray-500 text-sm max-w-2xl mx-auto">Solusi holistik yang mengintegrasikan kenyamanan teknologi dengan kehangatan dukungan profesional.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-32">
                <!-- Card 1 -->
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Booking Mudah</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Jadwalkan awal konseling dengan guru pilihanmu secara instan tanpa perlu mengantri atau menunggu lama.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Analisis Bakat</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Kenali potensi dirimu melalui fitur rekomendasi jurusan yang akurat berbasis tes psikologi terstandar.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-white border border-gray-100 rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-3">Privasi Terjamin</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Semua data dan sesi bersifat rahasia dan aman dengan protokol keamanan standar internasional.</p>
                </div>
            </div>

            <!-- Untuk Siapa TemanCerita Smansus? -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-32">
                <div class="relative w-full h-[400px] md:h-[500px]">
                    <div class="absolute inset-0 bg-white border border-gray-100 rounded-[2rem] shadow-sm flex items-center justify-center overflow-hidden">
                        <!-- Abstract illustration placeholder -->
                        <div class="w-full h-full relative bg-gray-50/50">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-2xl opacity-20"></div>
                                <div class="w-64 h-64 bg-sky-400 rounded-full mix-blend-multiply filter blur-2xl opacity-20 -ml-20"></div>
                            </div>
                            <svg class="absolute inset-0 w-full h-full opacity-30 text-gray-400" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="0,100 100,0 100,100"/></svg>
                        </div>
                    </div>
                    <!-- Floating Badge -->
                    <div class="absolute -bottom-6 left-10 bg-white px-6 py-4 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <div>
                            <div class="text-xs text-gray-500 font-medium">Peningkatan kehadiran</div>
                            <div class="text-sm font-bold text-gray-900">+20% Sesi Terjadwal</div>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-10">Untuk Siapa TemanCerita Smansus?</h2>
                    
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-sky-50 text-sky-600 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Siswa</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Layanan proaktif dan responsif yang peduli pada kecemasan Anda. Privasi mutlak memberikan ruang aman untuk bercerita tanpa stigma.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Guru Konselor</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Efisiensi operasional dengan manajemen jadwal otomatis dan dashboard pemantauan kondisi mental siswa secara real-time.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Sekolah</h3>
                                <p class="text-gray-500 text-sm leading-relaxed">Meningkatkan standar pelayanan kesejahteraan siswa dan memudahkan pelaporan berkala bagi pihak manajemen.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonial Quote -->
            <div class="bg-sky-50 rounded-[3rem] p-12 md:p-20 text-center mb-32 max-w-5xl mx-auto">
                <div class="text-sky-400 mb-6 flex justify-center">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 32 32">
                        <path d="M9.333 13.333c0-3.682 2.985-6.667 6.667-6.667V0C7.163 0 0 7.163 0 16v16h16V13.333H9.333zM32 13.333c0-3.682-2.985-6.667-6.667-6.667V0c-8.837 0-16 7.163-16 16v16h16V13.333H32z"/>
                    </svg>
                </div>
                <p class="text-lg md:text-xl text-gray-600 font-medium italic leading-relaxed mb-8">
                    "Kesehatan mental adalah fondasi keberhasilan akademis. Melalui TemanCerita Smansus, kami tidak hanya memberikan solusi teknis, tetapi membangun jembatan empati antara siswa dan pendidik."
                </p>
                <div class="flex flex-col items-center">
                    <div class="w-12 h-12 bg-sky-200 rounded-full mb-3 border-2 border-white shadow-sm"></div>
                    <div class="text-sm font-bold text-gray-900">Dr. Andi Pratama</div>
                    <div class="text-xs text-gray-500">Pakar Psikologi Pendidikan</div>
                </div>
            </div>

            <!-- CTA 1 -->
            <div class="bg-[#27272a] rounded-[2.5rem] p-12 md:p-16 text-center text-white mb-20">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Melangkah Lebih Jauh?</h2>
                <p class="text-gray-400 mb-10 max-w-xl mx-auto text-sm leading-relaxed">Bergabunglah dengan ratusan siswa yang telah menemukan kenyamanan dan arah masa depan bersama TemanCerita Smansus.</p>
                <a href="{{ route('login') }}" class="inline-block px-8 py-3.5 bg-[#0284c7] hover:bg-[#0369a1] text-white font-semibold rounded-xl shadow-lg transition-all text-sm">Login ke Dashboard</a>
            </div>
        </section>

        <!-- FEATURES SECTION -->
        <section id="features" class="bg-white border-t border-gray-100 py-20 md:py-24">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Header Section -->
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-1.5 bg-sky-50 text-[#0284c7] font-bold text-xs rounded-full mb-6 tracking-wide">FITUR UNGGULAN</span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Platform konseling terintegrasi</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto text-sm leading-relaxed">Dirancang untuk mendukung pertumbuhan emosional siswa, efisiensi konselor, dan transparansi data sekolah dalam satu ekosistem yang aman.</p>
                </div>

                <!-- Divider: Untuk Siswa -->
                <div class="flex items-center gap-4 mb-10 mt-20">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-[#0284c7] font-semibold text-sm">Untuk Siswa</span>
                    <hr class="flex-1 border-gray-200">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="col-span-1 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3 text-lg">Analisis Bakat</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Temukan potensi tersembunyi Anda melalui kuesioner bakat yang dikembangkan oleh psikolog profesional. Dapatkan profil komprehensif untuk masa depan Anda.</p>
                    </div>
                    <div class="col-span-1 md:col-span-1 bg-gray-50 rounded-3xl flex items-center justify-center border border-gray-100 min-h-[250px] p-6 relative overflow-hidden">
                        <!-- Pentagon chart placeholder -->
                        <div class="w-40 h-40 border-2 border-green-200 bg-green-50/50 absolute" style="clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);"></div>
                        <div class="w-32 h-32 border border-green-300 bg-green-200/40 absolute" style="clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%);"></div>
                        
                        <!-- Radar points -->
                        <div class="absolute w-2 h-2 bg-sky-500 rounded-full top-[15%]"></div>
                        <div class="absolute w-2 h-2 bg-sky-500 rounded-full top-[42%] right-[12%]"></div>
                        <div class="absolute w-2 h-2 bg-sky-500 rounded-full bottom-[15%] right-[22%]"></div>
                        <div class="absolute w-2 h-2 bg-sky-500 rounded-full bottom-[15%] left-[22%]"></div>
                        <div class="absolute w-2 h-2 bg-sky-500 rounded-full top-[42%] left-[12%]"></div>
                        
                        <svg class="w-full h-full text-gray-200 absolute inset-0 opacity-50" viewBox="0 0 100 100"><path stroke="currentColor" stroke-width="0.5" fill="none" d="M50 50L50 0M50 50L97 34M50 50L80 95M50 50L20 95M50 50L3 34"/></svg>
                    </div>
                    <div class="col-span-1 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3 text-lg">Booking Konseling</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Pilih waktu dan konselor favorit Anda tanpa antrean. Proses aman dan nyaman untuk kenyamanan bercerita.</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-20">
                    <div class="col-span-1 bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 mb-6">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 mb-3 text-lg">Jurnal Wellness</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Pantau kesehatan mental harian Anda dengan jurnal interaktif. Dapatkan rekomendasi aktivitas berdasarkan perasaan Anda hari ini.</p>
                    </div>
                    <div class="col-span-1 md:col-span-2 bg-[#0284c7] rounded-3xl p-10 flex flex-col md:flex-row items-center justify-between text-white shadow-lg shadow-sky-200">
                        <div class="mb-6 md:mb-0">
                            <h3 class="font-bold text-2xl mb-2">Siap Mengeksplorasi Diri Lebih Dalam?</h3>
                            <p class="text-sky-100 text-sm">Mulai perjalanan kesehatan mental Anda bersama TemanCerita Smansus.</p>
                        </div>
                        <a href="{{ route('login') }}" class="px-8 py-3.5 bg-white text-[#0284c7] font-bold rounded-xl hover:bg-gray-50 transition-all text-sm shrink-0">Coba Sekarang</a>
                    </div>
                </div>

                <!-- Divider: Untuk Konselor -->
                <div class="flex items-center gap-4 mb-10 mt-20">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-[#0284c7] font-semibold text-sm">Untuk Konselor</span>
                    <hr class="flex-1 border-gray-200">
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-12">
                    <div>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs font-bold rounded-full mb-4 border border-green-100">Efisiensi Kinerja</span>
                        <h3 class="font-bold text-gray-900 text-3xl mb-4">Manajemen Jadwal Otomatis</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 max-w-md">Lupakan pencatatan manual yang melelahkan. Sistem cerdas kami mengsinkronisasi jadwal konseling, mengirimkan pengingat otomatis kepada siswa, dan mengatur ulang slot kosong secara real-time.</p>
                        <ul class="space-y-4 text-sm text-gray-700 font-medium">
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                Sinkronisasi Google Calendar & Outlook
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                Notifikasi WhatsApp & Email Otomatis
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 rounded-[2rem] p-6 h-80 border border-gray-100 flex items-center justify-center shadow-inner relative overflow-hidden">
                        <!-- Dashboard UI Mockup 1 -->
                        <div class="w-full h-full bg-white rounded-xl shadow border border-gray-100 p-3 opacity-90">
                            <!-- Nav mockup -->
                            <div class="flex gap-2 mb-4">
                                <div class="w-16 h-3 bg-gray-200 rounded-full"></div>
                                <div class="w-8 h-3 bg-gray-100 rounded-full"></div>
                            </div>
                            <div class="grid grid-cols-5 gap-3 h-full pb-6">
                                <!-- Calendar columns mockup -->
                                <div class="bg-gray-50 rounded-lg flex flex-col items-center py-2"><div class="w-4 h-4 bg-gray-200 rounded-full mb-2"></div><div class="w-full h-12 bg-white border border-gray-100 shadow-sm rounded mb-2"></div></div>
                                <div class="bg-sky-50 rounded-lg flex flex-col items-center py-2"><div class="w-4 h-4 bg-sky-200 rounded-full mb-2"></div><div class="w-full h-12 bg-white border border-sky-100 shadow-sm rounded mb-2"></div><div class="w-full h-20 bg-[#0284c7] text-white text-[8px] p-1 rounded">Sesi Konseling</div></div>
                                <div class="bg-gray-50 rounded-lg flex flex-col items-center py-2"><div class="w-4 h-4 bg-gray-200 rounded-full mb-2"></div><div class="w-full h-12 bg-white border border-gray-100 shadow-sm rounded mb-2"></div></div>
                                <div class="bg-sky-50 rounded-lg flex flex-col items-center py-2"><div class="w-4 h-4 bg-sky-200 rounded-full mb-2"></div><div class="w-full h-16 bg-[#0284c7] text-white text-[8px] p-1 rounded mb-2">Sesi Konseling</div></div>
                                <div class="bg-gray-50 rounded-lg flex flex-col items-center py-2"><div class="w-4 h-4 bg-gray-200 rounded-full mb-2"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20 mt-12">
                    <div class="bg-gray-50 rounded-[2rem] p-8 h-80 border border-gray-100 flex flex-col justify-end shadow-inner order-2 lg:order-1 relative overflow-hidden">
                        <!-- Chart Mockup -->
                        <div class="w-full h-48 flex items-end justify-around gap-2 opacity-90 z-10">
                            <!-- Bar chart -->
                            <div class="w-full h-full flex items-end justify-around px-4">
                                <div class="w-8 bg-sky-200 h-1/4 rounded-t-sm"></div>
                                <div class="w-8 bg-sky-300 h-[40%] rounded-t-sm"></div>
                                <div class="w-8 bg-sky-400 h-1/2 rounded-t-sm"></div>
                                <div class="w-8 bg-sky-500 h-[70%] rounded-t-sm"></div>
                                <div class="w-8 bg-[#0284c7] h-full rounded-t-sm"></div>
                            </div>
                            <!-- Line chart placeholder -->
                            <div class="w-full h-full relative">
                                <svg class="absolute inset-0 w-full h-full text-green-400" preserveAspectRatio="none" viewBox="0 0 100 100"><path fill="currentColor" fill-opacity="0.2" d="M0 100 L0 80 L20 60 L40 70 L60 40 L80 50 L100 20 L100 100 Z"/><path fill="none" stroke="currentColor" stroke-width="2" d="M0 80 L20 60 L40 70 L60 40 L80 50 L100 20"/></svg>
                            </div>
                        </div>
                    </div>
                    <div class="order-1 lg:order-2">
                        <span class="inline-block px-3 py-1 bg-sky-50 text-sky-600 text-xs font-bold rounded-full mb-4 border border-sky-100">Data Driven Support</span>
                        <h3 class="font-bold text-gray-900 text-3xl mb-4">Dashboard Insights</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-8 max-w-md">Dapatkan gambaran menyeluruh tentang kesejahteraan kolektif siswa. Deteksi dini tren penurunan kesehatan emosional, tingkat kepuasan sesi, dan identifikasi siswa yang membutuhkan perhatian lebih.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 flex-1">
                                <div class="font-bold text-[#0284c7] text-2xl mb-1">92%</div>
                                <div class="text-xs font-medium text-gray-600">Akurasi Deteksi Dini</div>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 flex-1">
                                <div class="font-bold text-green-600 text-2xl mb-1">15+</div>
                                <div class="text-xs font-medium text-gray-600">Indikator Psikologis</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Divider: Solusi Sekolah -->
                <div class="flex items-center gap-4 mb-10 mt-20">
                    <hr class="flex-1 border-gray-200">
                    <span class="text-[#0284c7] font-semibold text-sm">Solusi Strategis untuk Sekolah</span>
                    <hr class="flex-1 border-gray-200">
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-24">
                    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-8 flex items-start gap-5 hover:border-sky-100 transition-colors">
                        <div class="w-12 h-12 bg-sky-50 rounded-2xl flex items-center justify-center text-sky-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">Laporan Berkala</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">Laporan komprehensif bulanan dan semesteran yang siap pakai untuk keperluan akreditasi dan evaluasi program sekolah.</p>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-3xl shadow-sm p-8 flex items-start gap-5 hover:border-green-100 transition-colors">
                        <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-green-600 shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 mb-2">Data Analytics</h3>
                            <p class="text-sm text-gray-500 leading-relaxed">Analitik prediktif untuk membantu manajemen sekolah mengambil kebijakan berbasis data guna menunjang iklim belajar-mengajar.</p>
                        </div>
                    </div>
                </div>

                <!-- CTA 2 Footer -->
                <div class="text-center bg-gray-50 rounded-[3rem] py-16 px-6 border border-gray-100">
                    <p class="text-sm font-bold text-gray-400 mb-2 uppercase tracking-wide">Siap untuk memulai?</p>
                    <h2 class="text-2xl font-bold text-gray-900 mb-8 max-w-xl mx-auto leading-relaxed">Bergabunglah dengan ratusan sekolah yang telah memodernisasi layanan konseling mereka bersama TemanCerita Smansus.</h2>
                    <div class="flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-3.5 bg-[#0284c7] hover:bg-[#0369a1] text-white font-semibold rounded-xl shadow-md transition-all text-sm">Daftar Sekarang</a>
                        <a href="#" class="px-8 py-3.5 border border-[#0284c7] text-[#0284c7] hover:bg-sky-50 font-semibold rounded-xl transition-all text-sm">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <img src="{{ asset('images/logo-smanbinsuskotadumai.png') }}" class="w-6 h-6 object-contain" alt="Logo Smansus">
                        <div class="text-[#0284c7] font-bold text-lg tracking-tight">TemanCerita Smansus</div>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed mb-6">Membangun generasi tangguh melalui hubungan emosional yang cerdas dan terukur.</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Produk</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#features" class="hover:text-sky-600 transition">Fitur Utama</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Harga</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Demo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Dukungan</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Portal</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="{{ route('login') }}" class="hover:text-sky-600 transition">Counselor Portal</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-sky-600 transition">Admin Sekolah</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-gray-400">&copy; {{ date('Y') }} TemanCerita Smansus. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
