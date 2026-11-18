<x-admin-layout headerTitle="Data Guru BK" headerSubtitle="Kelola profil Guru BK yang dapat menerima jadwal konseling.">
    
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

    <div x-data="{
        createModal: false,
        editModal: false,
        pencarian: '',
        editBidangPilihan: '',
        pilihanBidang: ['Psikologi anak', 'Jurusan dan karier', 'Prestasi dan akademik'],
        editForm: {
            id: '',
            nama_lengkap: '',
            email: '',
            nip: '',
            bidang_keahlian: '',
            alamat: '',
            no_hp: '',
            password: ''
        },
        openEdit(data) {
            this.editForm.id = data.id;
            this.editForm.nama_lengkap = data.nama;
            this.editForm.email = data.email;
            this.editForm.nip = data.nip;
            this.editForm.bidang_keahlian = data.bidang;
            this.editForm.alamat = data.alamat;
            this.editForm.no_hp = data.noHp;
            this.editBidangPilihan = !data.bidang ? '' : (this.pilihanBidang.includes(data.bidang) ? data.bidang : '__lainnya');
            this.editForm.password = '';
            this.editModal = true;
        }
    }">
        <x-card>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Data Guru BK</h3>
                    <p class="text-sm text-gray-500">Kelola profil Guru BK yang dapat menerima jadwal konseling.</p>
                </div>
                <button type="button" @click="createModal = true" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Guru BK
                </button>
            </div>

            <div class="flex flex-col md:flex-row gap-4 mb-6">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="search" x-model="pencarian" aria-label="Cari nama guru BK" placeholder="Cari nama guru BK..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <th class="p-4 rounded-tl-lg">Nama</th>
                            <th class="p-4">NIP</th>
                            <th class="p-4">Bidang Layanan</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">No. HP</th>
                            <th class="p-4">Alamat</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 rounded-tr-lg">Aksi</th>
                        </tr>
                    </thead>
                    <tbody x-ref="barisGuru" class="divide-y divide-gray-100">
                        @forelse($gurus as $guru)
                        <tr class="hover:bg-gray-50/50 transition" data-nama="{{ $guru->nama_lengkap }}" x-show="$el.dataset.nama.toLocaleLowerCase().includes(pencarian.trim().toLocaleLowerCase())">
                            <td class="p-4">
                                <h4 class="text-sm font-bold text-gray-900">{{ $guru->nama_lengkap }}</h4>
                            </td>
                            <td class="p-4 text-sm text-gray-500">{{ $guru->nip ?? '-' }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $guru->bidang_keahlian ?: 'Belum diisi' }}</td>
                            <td class="p-4 text-sm text-gray-500">{{ $guru->user->email }}</td>
                            <td class="p-4 text-sm text-gray-500 whitespace-nowrap">{{ $guru->no_hp ?: '-' }}</td>
                            <td class="p-4 text-sm text-gray-500 min-w-[180px] whitespace-pre-line break-words">{{ $guru->alamat ?: '-' }}</td>
                            <td class="p-4 align-middle">
                                <span class="inline-flex px-2 py-1 text-[10px] font-bold bg-green-100 text-green-700 rounded-md">Aktif</span>
                            </td>
                            <td class="p-4 align-middle">
                                <div class="flex items-center gap-2">
                                <button type="button" data-id="{{ $guru->id }}" data-nama="{{ $guru->nama_lengkap }}" data-email="{{ $guru->user->email }}" data-nip="{{ $guru->nip }}" data-bidang="{{ $guru->bidang_keahlian }}" data-alamat="{{ $guru->alamat }}" data-no-hp="{{ $guru->no_hp }}" @click="openEdit($el.dataset)" class="rounded-lg bg-blue-50 px-3 py-2 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">Edit</button>
                                <form action="{{ route('admin.guru.destroy', $guru->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">Hapus</button>
                                </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-sm text-gray-500">Belum ada data Guru BK.</td>
                        </tr>
                        @endforelse
                        <tr x-cloak x-show="pencarian.trim() !== '' && !Array.from($refs.barisGuru.querySelectorAll('[data-nama]')).some(baris => baris.dataset.nama.toLocaleLowerCase().includes(pencarian.trim().toLocaleLowerCase()))"><td colspan="8" class="p-6 text-center text-sm text-gray-500">Tidak ada guru BK yang cocok dengan pencarian.</td></tr>
                    </tbody>
                </table>
            </div>
        </x-card>

        <!-- Create Modal -->
        <div x-show="createModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4" x-cloak style="display: none;">
            <div role="dialog" aria-modal="true" aria-label="Tambah Guru BK" @keydown.escape.window="createModal = false" class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-xl" @click.away="createModal = false">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-base font-bold text-gray-900">Tambah Guru BK</h3>
                    <button @click="createModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.guru.store') }}" method="POST">
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP (Opsional)</label>
                            <input type="text" name="nip" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bidang Layanan (Opsional)</label>
                            <input type="text" name="bidang_keahlian" maxlength="255" list="bidang-layanan" placeholder="Contoh: psikologi anak, karier" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Tuliskan bidang layanan yang ditangani guru BK.</p>
                        </div>
                        <div>
                            <label for="tambah-no-hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP (Opsional)</label>
                            <input id="tambah-no-hp" type="tel" name="no_hp" maxlength="30" autocomplete="tel" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="tambah-alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat (Opsional)</label>
                            <textarea id="tambah-alamat" name="alamat" maxlength="1000" rows="2" autocomplete="street-address" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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
            <div role="dialog" aria-modal="true" aria-label="Edit Guru BK" @keydown.escape.window="editModal = false" class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-2xl bg-white shadow-xl" @click.away="editModal = false">
                <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="text-base font-bold text-gray-900">Edit Guru BK</h3>
                    <button @click="editModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form :action="'/admin/guru/' + editForm.id" method="POST">
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
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIP (Opsional)</label>
                            <input type="text" name="nip" x-model="editForm.nip" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="edit-bidang-pilihan" class="block text-sm font-medium text-gray-700 mb-1">Bidang Layanan (Opsional)</label>
                            <select id="edit-bidang-pilihan" x-model="editBidangPilihan" @change="editForm.bidang_keahlian = $event.target.value === '__lainnya' ? '' : $event.target.value" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Belum diisi</option>
                                <option value="Psikologi anak">Psikologi anak</option>
                                <option value="Jurusan dan karier">Jurusan dan karier</option>
                                <option value="Prestasi dan akademik">Prestasi dan akademik</option>
                                <option value="__lainnya">Lainnya</option>
                            </select>
                            <div x-show="editBidangPilihan === '__lainnya'" x-cloak class="mt-2">
                                <label for="edit-bidang-lainnya" class="sr-only">Bidang layanan lainnya</label>
                                <input id="edit-bidang-lainnya" type="text" x-model="editForm.bidang_keahlian" maxlength="255" placeholder="Tuliskan bidang layanan" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <input type="hidden" name="bidang_keahlian" :value="editForm.bidang_keahlian">
                        </div>
                        <div>
                            <label for="edit-no-hp" class="block text-sm font-medium text-gray-700 mb-1">No. HP (Opsional)</label>
                            <input id="edit-no-hp" type="tel" name="no_hp" x-model="editForm.no_hp" maxlength="30" autocomplete="tel" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="edit-alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat (Opsional)</label>
                            <textarea id="edit-alamat" name="alamat" x-model="editForm.alamat" maxlength="1000" rows="2" autocomplete="street-address" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
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
        <datalist id="bidang-layanan">
            <option value="Psikologi anak"></option>
            <option value="Jurusan dan karier"></option>
            <option value="Prestasi dan akademik"></option>
        </datalist>
    </div>
</x-admin-layout>
