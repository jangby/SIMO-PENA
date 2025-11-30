<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">

        <div class="bg-[#83218F] pt-8 pb-32 px-4 sticky top-0 z-0 shadow-md rounded-b-[2rem]">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 rounded-xl text-white hover:bg-white/20 transition backdrop-blur-md border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                
                <h1 class="text-white font-bold text-lg tracking-wide">Pengaturan Akun</h1>
                
                <div class="w-10"></div>
            </div>
        </div>

        <div class="px-4 -mt-24 relative z-40 max-w-xl mx-auto space-y-6">
            
            @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-2xl shadow-sm flex justify-between items-center mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="text-sm font-bold">Perubahan berhasil disimpan.</span>
                    </div>
                    <button @click="show = false">&times;</button>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-[#83218F]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Informasi Akun</h3>
                </div>

                <div class="p-6">
                    <form method="post" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Nama Akun</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                            <x-input-error class="mt-1" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Email Login</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                            <x-input-error class="mt-1" :messages="$errors->get('email')" />
                        </div>

                        <button type="submit" class="w-full bg-[#83218F] text-white py-3 rounded-xl font-bold text-sm shadow-md hover:bg-purple-800 transition active:scale-95">
                            Simpan Profil
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-lg overflow-hidden border border-gray-100">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Ganti Password</h3>
                </div>

                <div class="p-6">
                    <form method="post" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        @method('put')

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Password Saat Ini</label>
                            <input type="password" name="current_password" autocomplete="current-password" placeholder="••••••••"
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Password Baru</label>
                            <input type="password" name="password" autocomplete="new-password" placeholder="Minimal 8 karakter"
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Ulangi Password Baru</label>
                            <input type="password" name="password_confirmation" autocomplete="new-password" placeholder="••••••••"
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
                        </div>

                        <button type="submit" class="w-full bg-white border border-[#83218F] text-[#83218F] py-3 rounded-xl font-bold text-sm shadow-sm hover:bg-purple-50 transition active:scale-95">
                            Update Password
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-red-50 rounded-3xl p-6 border border-red-100 text-center">
                <h3 class="font-bold text-red-800 text-sm mb-2">Zona Berbahaya</h3>
                <p class="text-xs text-red-600 mb-4">Ingin menghapus akun secara permanen?</p>
                
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus akun? Semua data akan hilang.')" 
                            class="text-xs font-bold text-red-500 hover:text-red-700 underline">
                        Hapus Akun Saya
                    </button>
                </form>
            </div>

            <div class="text-center pb-8">
                <p class="text-[10px] text-gray-400">Versi Aplikasi 1.0.0 &bull; PAC IPNU Limbangan</p>
            </div>

        </div>
    </div>
</x-app-layout>