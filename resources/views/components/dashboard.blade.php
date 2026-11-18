<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TemanCerita Smansus - Dashboard</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-gray-800 antialiased flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile sidebar backdrop -->
    <div x-cloak x-show="sidebarOpen" class="fixed inset-0 z-40 bg-gray-900/50 lg:hidden" @click="sidebarOpen = false" x-transition.opacity></div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 h-full flex flex-col shrink-0 transition-transform duration-300 lg:static lg:translate-x-0">
        <!-- Logo -->
        <div class="px-6 py-8 flex justify-between items-start">
            <div>
                <h1 class="text-xl font-bold text-gray-900 leading-tight">TemanCerita<br>Smansus</h1>
                <p class="text-xs text-gray-500 mt-1">{{ $roleTitle ?? 'User' }}</p>
            </div>
            <!-- Close button for mobile -->
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- User Profile Card in Sidebar -->
        <div class="px-6 mb-6">
            <div class="border border-gray-200 rounded-xl p-3 flex items-center gap-3 shadow-sm">
                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                    {{ $userInitials ?? 'U' }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span>
                        <span class="text-xs text-green-600 font-medium">Online sekarang</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 overflow-y-auto space-y-1 pb-4">
            {{ $sidebar }}
        </nav>

        <!-- Logout -->
        <div class="p-4 mt-auto border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors w-full text-left">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-8">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Menu Button -->
                    <button @click="sidebarOpen = true" class="p-2 -ml-2 text-gray-600 rounded-lg lg:hidden hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $headerTitle ?? 'Dashboard' }}</h2>
                        <p class="text-sm text-gray-500 mt-1">{{ $headerSubtitle ?? 'Kelola data dan laporan Anda.' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <button class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-medium rounded-full hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        Notifikasi
                    </button>
                </div>
            </div>

            <!-- Page Content -->
            {{ $slot }}
        </div>
    </main>
</body>
</html>
