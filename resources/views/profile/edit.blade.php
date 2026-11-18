@php
    $layout = auth()->user()->role === 'admin' ? 'admin-layout' : (auth()->user()->role === 'guru' ? 'guru-layout' : 'siswa-layout');
@endphp

<x-dynamic-component :component="$layout" headerTitle="Pengaturan Profil" headerSubtitle="Kelola detail profil dan keamanan akun Anda.">
    
    @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             x-transition.duration.300ms class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <p class="text-sm font-medium">Pengaturan berhasil disimpan.</p>
            <button @click="show = false" class="text-green-500 hover:text-green-700 ml-auto shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <!-- Pengaturan Akun -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Akun</h3>
            
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-800 mb-2">Nama Lengkap</label>
                    <input id="name" name="name" type="text" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-gray-800 mb-2">Email</label>
                    <input id="email" name="email" type="email" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                @if(in_array($user->role, ['guru', 'siswa'], true))
                    @php
                        $profilKontak = $user->role === 'guru' ? $user->guru : $user->siswa;
                    @endphp
                    <div>
                        <label for="no_hp" class="block text-sm font-bold text-gray-800 mb-2">No. HP (Opsional)</label>
                        <input id="no_hp" name="no_hp" type="tel" maxlength="30" autocomplete="tel" value="{{ old('no_hp', $profilKontak?->no_hp) }}" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" />
                        <x-input-error class="mt-2" :messages="$errors->get('no_hp')" />
                    </div>
                    <div>
                        <label for="alamat" class="block text-sm font-bold text-gray-800 mb-2">Alamat (Opsional)</label>
                        <textarea id="alamat" name="alamat" maxlength="1000" rows="3" autocomplete="street-address" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">{{ old('alamat', $profilKontak?->alamat) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                    </div>
                @endif

                <div class="pt-2">
                    <button type="submit" class="px-6 py-3 bg-[#0d47a1] text-white font-semibold text-sm rounded-xl hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-all">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- Keamanan Sistem (Ganti Password) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            <h3 class="text-xl font-bold text-gray-900 mb-6">Keamanan Akun</h3>
            
            <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <div>
                    <label for="update_password_current_password" class="block text-sm font-bold text-gray-800 mb-2">Password Saat Ini</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" autocomplete="current-password" />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <label for="update_password_password" class="block text-sm font-bold text-gray-800 mb-2">Password Baru</label>
                    <input id="update_password_password" name="password" type="password" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-800 mb-2">Konfirmasi Password Baru</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" autocomplete="new-password" />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-3 bg-[#0d47a1] text-white font-semibold text-sm rounded-xl hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 transition-all">
                        Perbarui Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-dynamic-component>
