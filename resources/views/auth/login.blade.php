<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk | TemanCerita Smansus</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen bg-[#f4f7fb] text-slate-800 antialiased">
    <main class="min-h-screen lg:grid lg:grid-cols-2">
        <section class="relative overflow-hidden bg-[#0d2949] px-6 py-6 text-white sm:px-10 lg:flex lg:min-h-screen lg:flex-col lg:justify-between lg:px-14 lg:py-10 xl:px-20">
            <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-br from-[#123d65] via-[#0d2949] to-[#091d34]"></div>
            <div aria-hidden="true" class="pointer-events-none absolute -right-32 -top-44 h-96 w-96 rounded-full bg-sky-400/10 blur-3xl"></div>
            <div aria-hidden="true" class="pointer-events-none absolute -bottom-40 -left-24 h-96 w-96 rounded-full bg-teal-300/10 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative z-10 inline-flex w-fit items-center gap-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-4 focus:ring-offset-[#0d2949]">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white p-1.5 shadow-sm sm:h-12 sm:w-12"><img src="{{ asset('images/logo-smanbinsuskotadumai.png') }}" alt="Logo Smansus" class="h-full w-full object-contain"></span>
                <span><span class="block text-base font-bold tracking-tight sm:text-lg">TemanCerita</span><span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.14em] text-sky-100/70">SMANSUS Kota Dumai</span></span>
            </a>

            <div class="relative z-10 hidden max-w-xl py-10 lg:block">
                <span class="inline-flex items-center gap-2 rounded-full border border-sky-200/20 bg-white/5 px-3.5 py-1.5 text-xs font-semibold text-sky-100"><span class="h-2 w-2 rounded-full bg-teal-300"></span>Ruang untuk bercerita dan bertumbuh</span>
                <h1 class="mt-6 text-4xl font-bold leading-[1.16] tracking-tight xl:text-5xl">Setiap cerita<br><span class="text-sky-300">punya tempatnya.</span></h1>
                <p class="mt-5 max-w-md text-sm leading-7 text-slate-300 xl:text-base">Apa pun yang sedang kamu hadapi, mulailah dengan bercerita. Guru BK siap menemanimu mencari langkah selanjutnya.</p>

                <div class="relative mt-10 max-w-md overflow-hidden rounded-[28px] border border-white/10 bg-white/[0.06] p-5 shadow-2xl shadow-slate-950/10 xl:p-6">
                    <div class="flex items-center justify-between"><div class="flex items-center gap-2"><span class="h-2 w-2 rounded-full bg-teal-300"></span><span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-sky-100/75">Ruang cerita</span></div><svg class="h-5 w-5 text-sky-200/50" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2m0 14v2M3 12h2m14 0h2M5.6 5.6 7 7m10 10 1.4 1.4M18.4 5.6 17 7M7 17l-1.4 1.4"/></svg></div>
                    <div class="mt-6 flex items-start gap-3"><span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-sky-200 text-sky-900" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 0114 0"/></svg></span><div class="rounded-2xl rounded-tl-sm bg-white px-4 py-3 text-sm font-medium text-slate-700 shadow-sm">Aku ingin bercerita...</div></div>
                    <div class="mt-4 flex items-start justify-end gap-3"><div class="rounded-2xl rounded-tr-sm bg-sky-300 px-4 py-3 text-sm font-semibold text-sky-950 shadow-sm">Tentu, kami siap mendengarkan.</div><span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-teal-200 text-teal-900" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 12a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 0114 0"/></svg></span></div>
                    <p class="mt-6 border-t border-white/10 pt-4 text-xs leading-5 text-slate-300">Tidak perlu punya semua jawaban untuk memulai.</p>
                </div>
            </div>
            <p class="relative z-10 hidden text-xs text-slate-400 lg:block">&copy; {{ date('Y') }} TemanCerita Smansus · SMA Negeri Binsus Kota Dumai</p>
        </section>

        <section class="relative flex items-center justify-center px-5 py-10 sm:px-10 sm:py-14 lg:px-14">
            <div aria-hidden="true" class="pointer-events-none absolute right-0 top-0 hidden h-64 w-64 rounded-full bg-sky-100/60 blur-3xl sm:block"></div>
            <div class="relative w-full max-w-md">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-lg text-sm font-semibold text-slate-500 transition hover:text-sky-700 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7-7-7 7 7 7"/></svg>Kembali ke beranda</a>

                <div class="mt-7 rounded-[28px] border border-white bg-white p-6 shadow-[0_20px_60px_-24px_rgba(15,45,75,0.18)] sm:mt-9 sm:p-9">
                    <div class="mb-7"><span class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-sky-50 text-sky-700" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 11V7a3 3 0 00-6 0v4m-1 0h8a2 2 0 012 2v5a2 2 0 01-2 2H8a2 2 0 01-2-2v-5a2 2 0 012-2zm4 4v2"/></svg></span><p class="mt-6 text-xs font-bold uppercase tracking-[0.14em] text-sky-700">Selamat datang di TemanCerita</p><h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Masuk ke akun</h2><p class="mt-2 text-sm leading-6 text-slate-500">Gunakan email dan kata sandi yang terdaftar untuk melanjutkan.</p></div>

                    @if (session('status'))<div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>@endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Alamat email</label>
                            <div class="relative"><span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 6h16v12H4z M4 7l8 6 8-6"/></svg></span><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror class="block w-full rounded-xl border-slate-200 bg-slate-50/50 py-3.5 pl-12 pr-4 text-sm text-slate-900 placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-sky-500"></div>
                            @error('email')<p id="email-error" role="alert" class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div x-data="{ showPassword: false }">
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Kata sandi</label>
                            <div class="relative"><span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400" aria-hidden="true"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 11V8a4 4 0 118 0v3m-9 0h10a2 2 0 012 2v5a2 2 0 01-2 2H7a2 2 0 01-2-2v-5a2 2 0 012-2z"/></svg></span><input id="password" name="password" type="password" :type="showPassword ? 'text' : 'password'" required autocomplete="current-password" placeholder="Masukkan kata sandi" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror class="block w-full rounded-xl border-slate-200 bg-slate-50/50 py-3.5 pl-12 pr-24 text-sm text-slate-900 placeholder:text-slate-400 focus:border-sky-500 focus:bg-white focus:ring-sky-500"><button type="button" @click="showPassword = !showPassword" :aria-label="showPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'" :aria-pressed="showPassword.toString()" class="absolute inset-y-0 right-4 text-xs font-bold text-sky-700 hover:text-sky-900 focus:outline-none focus:underline" x-text="showPassword ? 'Sembunyikan' : 'Lihat'">Lihat</button></div>
                            @error('password')<p id="password-error" role="alert" class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex flex-wrap items-center justify-between gap-3 text-sm"><label for="remember_me" class="inline-flex cursor-pointer items-center gap-2 text-slate-600"><input id="remember_me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="rounded border-slate-300 text-sky-700 focus:ring-sky-500">Ingat saya</label>@if (Route::has('password.request'))<a href="{{ route('password.request') }}" class="font-semibold text-sky-700 hover:text-sky-900 focus:outline-none focus:underline">Lupa kata sandi?</a>@endif</div>
                        <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-sky-700 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-sky-700/20 transition hover:bg-sky-800 focus:outline-none focus:ring-4 focus:ring-sky-200">Masuk ke TemanCerita <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7-7 7 7-7 7"/></svg></button>
                    </form>
                    @if (Route::has('register'))<p class="mt-6 text-center text-sm text-slate-500">Siswa dan belum punya akun? <a href="{{ route('register') }}" class="font-bold text-sky-700 hover:text-sky-900 focus:outline-none focus:underline">Daftar di sini</a></p>@endif
                </div>
                <p class="mt-6 text-center text-xs leading-5 text-slate-500">Butuh bantuan untuk masuk? Hubungi admin sekolah atau guru BK.</p>
                <p class="mt-6 text-center text-xs text-slate-400 lg:hidden">&copy; {{ date('Y') }} TemanCerita Smansus</p>
            </div>
        </section>
    </main>
</body>
</html>
