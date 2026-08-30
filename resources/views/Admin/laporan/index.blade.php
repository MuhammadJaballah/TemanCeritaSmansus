<x-admin-layout headerTitle="Laporan Konseling" headerSubtitle="Kelola data, akun pengguna, dan laporan konseling sekolah.">
    <x-card>
        <div class="p-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Laporan Konseling</h2>
                    <p class="text-sm text-gray-500">Filter data sesi konseling selesai dan export dalam format spreadsheet.</p>
                </div>
                <a href="{{ route('admin.laporan.export', request()->all()) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Excel
                </a>
            </div>

            <!-- Filters -->
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1 md:max-w-xs">
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
                </div>
                <div class="relative flex-1 md:max-w-xs">
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600">
                </div>
                <div class="relative flex-1 md:max-w-xs">
                    <select name="kategori" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600 appearance-none bg-white">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('kategori') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <button type="submit" class="px-6 py-2 bg-white border border-gray-200 text-blue-600 font-medium rounded-lg text-sm hover:bg-gray-50 transition">
                    Filter
                </button>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Siswa</th>
                            <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Guru BK</th>
                            <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Tanggal</th>
                            <th class="pb-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($laporans as $laporan)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-4 text-sm font-bold text-gray-900">
                                    {{ $laporan->siswa->nama_lengkap ?? '-' }}
                                </td>
                                <td class="py-4 text-sm text-gray-600">
                                    {{ $laporan->jadwal->guru->nama_lengkap ?? '-' }}
                                </td>
                                <td class="py-4 text-sm text-gray-600">
                                    {{ $laporan->kategori_masalah }}
                                </td>
                                <td class="py-4 text-sm text-gray-900 font-bold">
                                    {{ $laporan->jadwal ? \Carbon\Carbon::parse($laporan->jadwal->tanggal)->translatedFormat('d M Y') : '-' }}
                                </td>
                                <td class="py-4">
                                    @php
                                        $status = strtolower($laporan->jadwal->status ?? '');
                                        $statusClass = 'bg-gray-100 text-gray-800';
                                        $statusLabel = ucfirst($status);
                                        
                                        if ($status == 'dibooking') {
                                            $statusClass = 'bg-yellow-100 text-yellow-800';
                                            $statusLabel = 'Dipesan';
                                        } elseif ($status == 'selesai') {
                                            $statusClass = 'bg-green-100 text-green-800';
                                        } elseif ($status == 'dibatalkan') {
                                            $statusClass = 'bg-red-100 text-red-800';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-sm text-gray-500">
                                    Tidak ada data laporan konseling yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </x-card>
</x-admin-layout>
