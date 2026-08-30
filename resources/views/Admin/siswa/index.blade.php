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

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6" x-data="{
        createModal: false,
        editModal: false,
        editForm: {
            id: '',
            nama_lengkap: '',
            email: '',
            nisn: '',
            kelas: '',
            password: ''
        },
        openEdit(id, nama, email, nisn, kelas) {
            this.editForm.id = id;
            this.editForm.nama_lengkap = nama;
            this.editForm.email = email;
            this.editForm.nisn = nisn;
            this.editForm.kelas = kelas;
            this.editForm.password = '';
            this.editModal = true;
        }
    }">
        <!-- Tabel Data Siswa -->
        <x-card class="xl:col-span-2">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Data Siswa</h3>
                    <p class="text-sm text-gray-500">Pendaftaran akun siswa dapat dilakukan manual atau secara massal.</p>
                </div>
                <button @click="createModal = true" class="px-4 py-2.5 bg-blue-600 text-white font-medium text-sm rounded-lg shadow-sm hover:bg-blue-700 transition flex items-center gap-2 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Siswa
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Cari nama / NIS siswa..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
                <select class="px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[150px]">
                    <option>Semua Kelas</option>
                    <option>X</option>
                    <option>XI</option>
                    <option>XII</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="p-4 rounded-tl-lg">Nama</th>
                            <th class="p-4">Kelas</th>
                            <th class="p-4">NIS</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($siswas as $siswa)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="p-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $siswa->nama_lengkap }}</h4>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $siswa->kelas ?? '-' }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $siswa->nisn ?? '-' }}</td>
                            <td class="p-4">
                                <span class="inline-flex px-2 py-1 text-[10px] font-bold bg-green-100 text-green-700 rounded-md">Aktif</span>
                            </td>
                            <td class="p-4 flex items-center gap-2">
                                <button @click="openEdit('{{ $siswa->id }}', '{{ addslashes($siswa->nama_lengkap) }}', '{{ addslashes($siswa->user->email) }}', '{{ addslashes($siswa->nisn) }}', '{{ addslashes($siswa->kelas) }}')" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-sm text-gray-500">Belum ada data Siswa.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Import Massal -->
        <x-card>
            <h3 class="text-lg font-bold text-gray-900 mb-6">Import Massal</h3>
            
            <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 flex flex-col items-center justify-center text-center bg-gray-50 hover:bg-gray-100 hover:border-blue-300 transition cursor-pointer">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                </div>
                <h4 class="text-base font-bold text-gray-900 mb-2">Upload Excel Siswa</h4>
                <p class="text-xs text-gray-500 mb-6">Simulasikan pendaftaran akun siswa aktif secara massal.</p>
                <button class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 transition w-full">
                    Pilih File Excel
                </button>
            </div>
        </x-card>

        <!-- Create Modal -->
        <div x-show="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak style="display: none;">
            <div class="bg-white rounded-xl shadow-xl w-[90%] md:w-[400px] overflow-hidden" @click.away="createModal = false">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIS (Opsional)</label>
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
            <div class="bg-white rounded-xl shadow-xl w-[90%] md:w-[400px] overflow-hidden" @click.away="editModal = false">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">NIS (Opsional)</label>
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
