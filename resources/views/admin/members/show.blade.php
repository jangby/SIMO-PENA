<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Kader: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.members.index') }}" class="inline-flex items-center mb-4 px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                &larr; Kembali
            </a>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="text-center md:text-left">
                            <div class="bg-gray-200 w-32 h-32 rounded-full mx-auto md:mx-0 flex items-center justify-center text-gray-500 mb-4 overflow-hidden">
                                @if($user->profile && $user->profile->photo)
                                    <img src="{{ asset('storage/' . $user->profile->photo) }}" class="w-full h-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                @endif
                            </div>
                            
                            <h3 class="font-bold text-xl">{{ $user->name }}</h3>
                            <p class="text-gray-500 text-sm mb-2">{{ $user->email }}</p>
                            
                            <span class="px-3 py-1 text-xs rounded-full {{ $user->role == 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="md:col-span-2 border-t md:border-t-0 md:border-l pt-4 md:pt-0 md:pl-6">
                            <h4 class="font-bold text-lg mb-4 text-green-700">Biodata Lengkap</h4>

                            @if($user->profile)
                                <div class="grid grid-cols-1 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">NIA (Nomor Induk Anggota)</label>
                                        <p class="font-medium">{{ $user->profile->nia_ipnu ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Asal Sekolah / Komisariat</label>
                                        <p class="font-medium">{{ $user->profile->school_origin ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Nomor HP / WA</label>
                                        <p class="font-medium">{{ $user->profile->phone ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 uppercase">Alamat</label>
                                        <p class="font-medium">{{ $user->profile->address ?? '-' }}</p>
                                    </div>
                                </div>
                            @else
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                    <div class="flex">
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700">
                                                User ini belum melengkapi profil biodatanya.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>