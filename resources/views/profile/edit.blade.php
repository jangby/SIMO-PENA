<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengaturan Akun Admin') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
                    <span class="text-sm font-bold">Data berhasil disimpan.</span>
                    <button @click="show = false">&times;</button>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Informasi Profil</h2>
                            <p class="mt-1 text-sm text-gray-600">Update nama akun dan alamat email admin.</p>
                        </header>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="name">Nama Admin</label>
                                <input class="border-gray-300 focus:border-[#83218F] focus:ring-[#83218F] rounded-md shadow-sm mt-1 block w-full" 
                                       id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                                <input class="border-gray-300 focus:border-[#83218F] focus:ring-[#83218F] rounded-md shadow-sm mt-1 block w-full" 
                                       id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-[#83218F] hover:bg-purple-800 text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-sm transition">
                                    Simpan Profil
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Ganti Password</h2>
                            <p class="mt-1 text-sm text-gray-600">Pastikan menggunakan password yang panjang dan aman.</p>
                        </header>

                        <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                            @csrf
                            @method('put')

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="current_password">Password Saat Ini</label>
                                <input class="border-gray-300 focus:border-[#83218F] focus:ring-[#83218F] rounded-md shadow-sm mt-1 block w-full" 
                                       id="current_password" name="current_password" type="password" autocomplete="current-password" />
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="password">Password Baru</label>
                                <input class="border-gray-300 focus:border-[#83218F] focus:ring-[#83218F] rounded-md shadow-sm mt-1 block w-full" 
                                       id="password" name="password" type="password" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block font-medium text-sm text-gray-700" for="password_confirmation">Konfirmasi Password Baru</label>
                                <input class="border-gray-300 focus:border-[#83218F] focus:ring-[#83218F] rounded-md shadow-sm mt-1 block w-full" 
                                       id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-bold text-xs uppercase tracking-widest shadow-sm transition">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>