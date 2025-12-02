<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Admin: {{ $organization->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('admin.organizations.index') }}" class="text-gray-500 hover:text-[#83218F] flex items-center gap-2 transition font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Daftar Organisasi
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
                    <h3 class="font-bold text-lg text-gray-800 mb-1">Buat Akun Admin Baru</h3>
                    <p class="text-xs text-gray-400 mb-6">Akun ini akan memiliki akses kelola data khusus {{ $organization->name }}.</p>

                    <form action="{{ route('admin.organizations.accounts.store', $organization->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Nama Pengurus / Admin</label>
                            <input type="text" name="name" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Misal: Admin PR Limbangan Timur" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Email Login</label>
                            <input type="email" name="email" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#83218F] focus:border-[#83218F]" placeholder="email@contoh.com" required>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Password</label>
                                <input type="password" name="password" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Konfirmasi</label>
                                <input type="password" name="password_confirmation" class="w-full border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                            @error('password') <span class="text-red-500 text-xs col-span-2">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
                            Buat Akun
                        </button>
                    </form>
                </div>

                <div class="space-y-4">
                    <h3 class="font-bold text-lg text-gray-800 mb-4 px-1">Daftar Admin Terdaftar</h3>

                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @forelse($admins as $admin)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:border-[#83218F] transition">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-[#83218F] font-bold">
                                {{ substr($admin->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">{{ $admin->name }}</div>
                                <div class="text-xs text-gray-400">{{ $admin->email }}</div>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.organizations.accounts.destroy', [$organization->id, $admin->id]) }}" method="POST" onsubmit="return confirm('Yakin hapus akun admin ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-300 hover:text-red-500 p-2 transition" title="Hapus Akses">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-400 text-sm">Belum ada admin untuk organisasi ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>