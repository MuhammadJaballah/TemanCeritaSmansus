<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - TemanCerita Smansus</title>
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
                <a href="{{ route('about') }}" class="text-gray-900 transition border-b-2 border-sky-500 pb-1">About Us</a>
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
        <!-- Hero Section -->
        <section class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold text-[#0284c7] leading-tight mb-6">Mendukung Langkah Anda Menuju Kesejahteraan</h1>
                <p class="text-gray-500 text-lg mb-8 leading-relaxed">
                    Di TemanCerita Smansus, kami percaya bahwa setiap individu layak mendapatkan ruang aman untuk tumbuh, sembuh, dan menemukan kedamaian batin melalui bimbingan profesional yang empatik.
                </p>
                <a href="#cerita" class="inline-block px-7 py-3.5 bg-[#0284c7] text-white font-semibold rounded-xl shadow-md shadow-sky-200 hover:bg-[#0369a1] transition-all text-sm">Pelajari Lebih Lanjut</a>
            </div>
            <div class="relative w-full h-80 md:h-[450px]">
                <div class="absolute inset-0 bg-gray-100 rounded-[2rem] shadow-sm border border-gray-200"></div>
                <div class="absolute bottom-8 right-1/2 translate-x-1/2 lg:translate-x-0 lg:bottom-10 lg:-left-10 bg-sky-100 text-[#0284c7] px-5 py-3 rounded-xl shadow-sm font-semibold flex items-center gap-2 text-sm border border-sky-200">
                    <svg class="w-5 h-5 text-sky-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.403 12.652a3 3 0 000-5.304 3 3 0 00-3.75-3.751 3 3 0 00-5.305 0 3 3 0 00-3.751 3.75 3 3 0 000 5.305 3 3 0 003.75 3.751 3 3 0 005.305 0 3 3 0 003.751-3.75zm-2.546-4.46a.75.75 0 00-1.214-.883l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"></path></svg>
                    Terpercaya & Berlisensi
                </div>
            </div>
        </section>

        <!-- Cerita Kami -->
        <section id="cerita" class="bg-white py-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-12">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="h-64 bg-gray-50 rounded-3xl border border-gray-100 shadow-sm"></div>
                        <div class="h-64 bg-gray-50 rounded-3xl border border-gray-100 shadow-sm mt-8"></div>
                    </div>
                    <div>
                        <span class="inline-block px-3 py-1 bg-sky-50 text-sky-600 font-bold text-xs rounded-full mb-4 border border-sky-100">Cerita Kami</span>
                        <h2 class="text-3xl md:text-4xl font-bold text-[#0284c7] mb-6">Awal Mula Sebuah Perjalanan</h2>
                        <p class="text-gray-500 mb-4 leading-relaxed text-sm">
                            TemanCerita Smansus didirikan dari sebuah visi sederhana: menciptakan jembatan antara kebutuhan kesehatan mental yang mendesak dengan layanan profesional yang terjangkau dan mudah diakses.
                        </p>
                        <p class="text-gray-500 leading-relaxed text-sm">
                            Kami menyadari bahwa langkah pertama mencari bantuan seringkali adalah yang tersulit. Oleh karena itu, kami membangun platform yang tidak hanya mengedepankan keahlian klinis, tetapi juga kehangatan dan kemudahan akses bagi seluruh lapisan masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visi & Nilai -->
        <section class="bg-gray-50 py-20 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-[#0284c7] mb-12">Visi Kami & Nilai Utama</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:border-sky-100 hover:shadow-md transition-all">
                        <div class="w-14 h-14 mx-auto bg-sky-50 text-[#0284c7] rounded-full flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0284c7] mb-3">Empati</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Kami mendengarkan tanpa menghakimi, memastikan setiap suara didengar dan setiap perasaan divalidasi dengan sepenuh hati.</p>
                    </div>
                    <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:border-sky-100 hover:shadow-md transition-all">
                        <div class="w-14 h-14 mx-auto bg-sky-50 text-[#0284c7] rounded-full flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0284c7] mb-3">Privasi</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Kerahasiaan Anda adalah prioritas tertinggi kami. Ruang aman yang kami sediakan dilindungi oleh prosedur keamanan ketat.</p>
                    </div>
                    <div class="bg-white p-10 rounded-3xl shadow-sm border border-gray-100 hover:border-sky-100 hover:shadow-md transition-all">
                        <div class="w-14 h-14 mx-auto bg-sky-50 text-[#0284c7] rounded-full flex items-center justify-center mb-6">
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 103.636 5.05l-.707.707a1 1 0 001.414 1.414l.707-.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[#0284c7] mb-3">Solusi</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Kami berfokus pada hasil yang terukur dan aplikatif membantu Anda menemukan strategi yang tepat untuk menghadapi tantangan hidup.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tim Profesional Kami -->
        <section class="bg-gray-100/50 py-20 border-t border-gray-200/60">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-[#0284c7] mb-4">Tim Profesional Kami</h2>
                <p class="text-gray-500 text-sm mb-12">Ahli yang berdedikasi untuk membantu kesehatan mental Anda</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Member 1 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
                        <div class="w-full h-48 bg-sky-50 rounded-2xl mb-5"></div>
                        <h3 class="font-bold text-[#0284c7] text-sm">Dr. Sarah Wijaya, M.Psi.</h3>
                        <p class="text-xs text-gray-500 mb-4">Psikolog Klinis Dewasa</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.231 2.413c1.464 0 2.653 1.185 2.653 2.646v13.882c0 1.46-1.189 2.646-2.653 2.646h-18.462c-1.465 0-2.654-1.186-2.654-2.646v-13.882c0-1.461 1.189-2.646 2.654-2.646h18.462zm-14.869 9.873c1.458.019 1.742-1.077 1.742-1.077.72-2.187 2.274-3.088 4.22-3.088 2.054 0 3.321 1.343 3.321 3.497v4.968h-1.921v-4.9c0-1.353-.615-1.922-1.716-1.922-1.636 0-2.164 1.11-2.164 2.89v3.932h-1.922v-6.938h1.86v1.171c.541-.854 1.474-1.353 2.721-1.353 2.128 0 3.143 1.293 3.143 3.705v5.337h3.769v-13.882c0-.365-.296-.662-.663-.662h-18.462c-.367 0-.663.297-.663.662v13.882h3.768v-8.195z"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- Member 2 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
                        <div class="w-full h-48 bg-sky-50 rounded-2xl mb-5"></div>
                        <h3 class="font-bold text-[#0284c7] text-sm">Budi Santoso, M.Psi.</h3>
                        <p class="text-xs text-gray-500 mb-4">Konselor Pernikahan</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.231 2.413c1.464 0 2.653 1.185 2.653 2.646v13.882c0 1.46-1.189 2.646-2.653 2.646h-18.462c-1.465 0-2.654-1.186-2.654-2.646v-13.882c0-1.461 1.189-2.646 2.654-2.646h18.462zm-14.869 9.873c1.458.019 1.742-1.077 1.742-1.077.72-2.187 2.274-3.088 4.22-3.088 2.054 0 3.321 1.343 3.321 3.497v4.968h-1.921v-4.9c0-1.353-.615-1.922-1.716-1.922-1.636 0-2.164 1.11-2.164 2.89v3.932h-1.922v-6.938h1.86v1.171c.541-.854 1.474-1.353 2.721-1.353 2.128 0 3.143 1.293 3.143 3.705v5.337h3.769v-13.882c0-.365-.296-.662-.663-.662h-18.462c-.367 0-.663.297-.663.662v13.882h3.768v-8.195z"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- Member 3 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
                        <div class="w-full h-48 bg-sky-50 rounded-2xl mb-5"></div>
                        <h3 class="font-bold text-[#0284c7] text-sm">Anita Putri, S.Psi., M.A.</h3>
                        <p class="text-xs text-gray-500 mb-4">Psikolog Anak & Remaja</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.231 2.413c1.464 0 2.653 1.185 2.653 2.646v13.882c0 1.46-1.189 2.646-2.653 2.646h-18.462c-1.465 0-2.654-1.186-2.654-2.646v-13.882c0-1.461 1.189-2.646 2.654-2.646h18.462zm-14.869 9.873c1.458.019 1.742-1.077 1.742-1.077.72-2.187 2.274-3.088 4.22-3.088 2.054 0 3.321 1.343 3.321 3.497v4.968h-1.921v-4.9c0-1.353-.615-1.922-1.716-1.922-1.636 0-2.164 1.11-2.164 2.89v3.932h-1.922v-6.938h1.86v1.171c.541-.854 1.474-1.353 2.721-1.353 2.128 0 3.143 1.293 3.143 3.705v5.337h3.769v-13.882c0-.365-.296-.662-.663-.662h-18.462c-.367 0-.663.297-.663.662v13.882h3.768v-8.195z"/></svg>
                            </a>
                        </div>
                    </div>
                    <!-- Member 4 -->
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all">
                        <div class="w-full h-48 bg-sky-50 rounded-2xl mb-5"></div>
                        <h3 class="font-bold text-[#0284c7] text-sm">Prof. Dr. Hendra Lim</h3>
                        <p class="text-xs text-gray-500 mb-4">Konselor Senior</p>
                        <div class="flex justify-center gap-3 text-gray-400">
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                            </a>
                            <a href="#" class="hover:text-[#0284c7] transition-colors">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21.231 2.413c1.464 0 2.653 1.185 2.653 2.646v13.882c0 1.46-1.189 2.646-2.653 2.646h-18.462c-1.465 0-2.654-1.186-2.654-2.646v-13.882c0-1.461 1.189-2.646 2.654-2.646h18.462zm-14.869 9.873c1.458.019 1.742-1.077 1.742-1.077.72-2.187 2.274-3.088 4.22-3.088 2.054 0 3.321 1.343 3.321 3.497v4.968h-1.921v-4.9c0-1.353-.615-1.922-1.716-1.922-1.636 0-2.164 1.11-2.164 2.89v3.932h-1.922v-6.938h1.86v1.171c.541-.854 1.474-1.353 2.721-1.353 2.128 0 3.143 1.293 3.143 3.705v5.337h3.769v-13.882c0-.365-.296-.662-.663-.662h-18.462c-.367 0-.663.297-.663.662v13.882h3.768v-8.195z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Tengah (Ingin Berdiskusi) -->
        <section class="bg-[#0284c7] py-20 relative overflow-hidden">
            <!-- Decorative curves -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path fill="none" stroke="white" stroke-width="0.5" d="M0,50 Q25,30 50,50 T100,50" />
                    <path fill="none" stroke="white" stroke-width="0.5" d="M0,60 Q25,40 50,60 T100,60" />
                    <path fill="none" stroke="white" stroke-width="0.5" d="M0,70 Q25,50 50,70 T100,70" />
                </svg>
            </div>
            
            <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
                <h2 class="text-3xl font-bold text-white mb-6">Ingin Berdiskusi Lebih Lanjut?</h2>
                <p class="text-sky-100 text-sm mb-10 leading-relaxed max-w-2xl mx-auto">Kami siap mendampingi setiap langkah Anda. Mulailah perjalanan kesehatan mental Anda hari ini dengan sesi konsultasi privat dan profesional.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-3.5 bg-white text-[#0284c7] font-semibold rounded-xl shadow-md hover:bg-gray-50 transition-all text-sm">Book Session Sekarang</a>
                    <a href="#" class="px-8 py-3.5 border border-white text-white font-semibold rounded-xl hover:bg-white/10 transition-all text-sm">Hubungi Support</a>
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
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Layanan</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">Konseling Individu</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Terapi Pasangan</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Psikologi Anak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Perusahaan</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="{{ route('about') }}" class="hover:text-sky-600 transition">About Us</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-sky-600 transition">Counselor Portal</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Contact Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 text-sm">Legal</h4>
                    <ul class="space-y-3 text-sm text-gray-500">
                        <li><a href="#" class="hover:text-sky-600 transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-sky-600 transition">Terms of Service</a></li>
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
