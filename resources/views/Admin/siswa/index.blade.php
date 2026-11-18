<x-admin-layout headerTitle="Data Siswa" headerSubtitle="Kelola data, akun pengguna, dan laporan konseling sekolah.">
    
    <!-- Toast Notifications -->
    <div class="fixed top-4 right-4 z-[60] flex flex-col gap-2">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 x-transition.duration.300ms class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-lg">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="text-green-500 hover:text-green-700 ml-4 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 x-transition.duration.300ms class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-lg">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-500 hover:text-red-700 ml-4 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif
        
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 x-transition.duration.300ms class="flex flex-col gap-1 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shadow-lg">
                <div class="flex items-center gap-3 justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm font-bold">Terjadi Kesalahan</p>
                    </div>
                    <button @click="show = false" class="text-red-500 hover:text-red-700 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <ul class="list-disc pl-9 text-xs mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="space-y-6" x-data="{
        createModal: false,
        editModal: false,
        importModal: @js($errors->import->any()),
        pencarian: '',
        filterKelas: '',
        editForm: {
            id: '',
            nama_lengkap: '',
            email: '',
            nisn: '',
            kelas: '',
            password: ''
        },
        openEdit(data) {
            this.editForm.id = data.id;
            this.editForm.nama_lengkap = data.nama;
            this.editForm.email = data.email;
            this.editForm.nisn = data.nisn;
            this.editForm.kelas = data.kelas;
            this.editForm.password = '';
            this.editModal = true;
        },
        cocok(data) {
            const cari = this.pencarian.trim().toLocaleLowerCase();
            return (!cari || data.nama.toLocaleLowerCase().includes(cari) || data.nisn.toLocaleLowerCase().includes(cari)) && (!this.filterKelas || data.kelas === this.filterKelas);
        }
    }">
        <!-- Tabel Data Siswa -->
        <x-card>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Data Siswa</h3>
                    <p class="text-sm text-gray-500">Kelola profil dan akun siswa yang menggunakan layanan konseling.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" @click="importModal = true" class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition hover:bg-blue-100">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 16V4m-4 4 4-4 4 4M4 17v2a2 2 0 002 2h12a2 2 0 002-2v-2"/></svg>
                        Impor Excel
                    </button>
                    <button type="button" @click="createModal = true" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Siswa
                    </button>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="search" x-model="pencarian" aria-label="Cari nama atau NISN siswa" placeholder="Cari nama / NISN siswa..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <select x-model="filterKelas" aria-label="Filter kelas" class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[150px]">
                    <option value="">Semua Kelas</option>
                    @foreach($siswas->pluck('kelas')->filter()->unique()->sort() as $kelas)<option value="{{ $kelas }}">{{ $kelas }}</option>@endforeach
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="p-4 rounded-tl-lg">Nama</th>
                            <th class="p-4">Kelas</th>
                            <th class="p-4">NISN</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody x-ref="barisSiswa" class="divide-y divide-gray-100">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50/50 transition" data-nama="{{ $siswa->nama_lengkap }}" data-nisn="{{ $siswa->nisn }}" data-kelas="{{ $siswa->kelas }}" x-show="cocok($el.dataset)">
                            <td class="p-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h4>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $siswa->kelas ?? '-' }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $siswa->nisn ?? '-' }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $siswa->user->email }}</td>
                            <td class="p-4 align-middle">
                                <span class="inline-flex px-2 py-1 text-[10px] font-bold bg-green-100 text-green-700 rounded-md">Aktif</span>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-2">
                                <button type="button" data-id="{{ $siswa->id }}" data-nama="{{ $siswa->nama_lengkap }}" data-email="{{ $siswa->user->email }}" data-nisn="{{ $siswa->nisn }}" data-kelas="{{ $siswa->kelas }}" @click="openEdit($el.dataset)" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">Edit</button>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">Hapus</button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-sm text-gray-500">Belum ada data Siswa.</td>
                        </tr>
                        @endforelse
                        <tr x-cloak x-show="(pencarian.trim() !== '' || filterKelas !== '') && !Array.from($refs.barisSiswa.querySelectorAll('tr[data-nama]')).some(baris => cocok(baris.dataset))"><td colspan="6" class="p-6 text-center text-sm text-gray-500">Tidak ada siswa yang cocok dengan filter.</td></tr>
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Import Modal -->
        <div x-show="importModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak>
            <div role="dialog" aria-modal="true" aria-labelledby="judul-impor-siswa" @keydown.escape.window="importModal = false" @click.away="importModal = false" class="max-h-[90vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white shadow-xl">
                <div class="flex items-start justify-between gap-4 border-b border-gray-100 px-6 py-5"><div><h3 id="judul-impor-siswa" class="text-lg font-bold text-gray-900">Impor Data Siswa</h3><p class="mt-1 text-sm text-gray-500">Tambahkan beberapa akun siswa melalui file Excel.</p></div><button type="button" @click="importModal = false" aria-label="Tutup" class="text-xl text-gray-400 hover:text-gray-700">&times;</button></div>
                <form action="{{ route('admin.siswa.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-5 p-6">
                        @if($errors->import->any())<div role="alert" class="rounded-xl border border-red-100 bg-red-50 p-4 text-sm text-red-700"><p class="font-bold">Impor belum berhasil</p><ul class="mt-2 list-disc space-y-1 pl-5">@foreach($errors->import->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                        <div class="rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900"><p class="font-semibold">Mulai dari template</p><p class="mt-1 leading-6">Isi nama lengkap, email, NISN, dan kelas di lembar pertama. Nama dan email wajib; simpan NISN sebagai teks agar angka nol di depan tetap ada.</p><a href="{{ route('admin.siswa.template-import') }}" class="mt-2 inline-block font-semibold text-blue-700 underline hover:text-blue-900">Unduh template Excel</a></div>
                        <div><label for="file-impor" class="mb-2 block text-sm font-semibold text-gray-700">File Excel (.xlsx)</label><input id="file-impor" type="file" name="file" accept=".xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required class="block w-full rounded-xl border border-gray-200 p-2 text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-100 file:px-3 file:py-2 file:font-semibold file:text-gray-700"><p class="mt-1 text-xs text-gray-500">Maksimal 2 MB dan 1.000 siswa. Seluruh baris diperiksa sebelum disimpan.</p></div>
                        <div><label for="password-impor" class="mb-2 block text-sm font-semibold text-gray-700">Kata sandi awal siswa</label><input id="password-impor" type="password" name="password" minlength="8" maxlength="72" required autocomplete="new-password" class="w-full rounded-xl border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"><p class="mt-1 text-xs text-gray-500">Minimal 8 karakter. Kata sandi ini digunakan untuk semua akun dalam file; minta siswa menggantinya setelah masuk.</p></div>
                    </div>
                    <div class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4"><button type="button" @click="importModal = false" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">Batal</button><button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Impor siswa</button></div>
                </form>
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak style="display: none;">
            <div role="dialog" aria-modal="true" aria-label="Tambah Siswa" @keydown.escape.window="createModal = false" class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-xl" @click.away="createModal = false">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-base font-bold text-gray-900">Tambah Siswa</h3>
                    <button @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.siswa.store') }}" method="POST">
                    @csrf
                    <div class="p-5 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NISN (Opsional)</label>
                                <input type="text" name="nisn" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas (Opsional)</label>
                                <input type="text" name="kelas" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 flex justify-end gap-3 bg-gray-50">
                        <button type="button" @click="createModal = false" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak style="display: none;">
            <div role="dialog" aria-modal="true" aria-label="Edit Siswa" @keydown.escape.window="editModal = false" class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-xl" @click.away="editModal = false">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-base font-bold text-gray-900">Edit Siswa</h3>
                    <button @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'/admin/siswa/' + editForm.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="p-5 space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" x-model="editForm.nama_lengkap" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" x-model="editForm.email" required class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">NISN (Opsional)</label>
                                <input type="text" name="nisn" x-model="editForm.nisn" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas (Opsional)</label>
                                <input type="text" name="kelas" x-model="editForm.kelas" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                            <input type="password" name="password" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 flex justify-end gap-3 bg-gray-50">
                        <button type="button" @click="editModal = false" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium text-sm rounded-lg hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium text-sm rounded-lg hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
