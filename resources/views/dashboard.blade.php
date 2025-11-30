<x-app-layout>
    <style>
        /* Paksa sembunyikan navbar bawaan jika masih muncul */
        nav[x-data] { display: none !important; }
    </style>

    <div class="min-h-screen bg-gray-50 pb-20 font-sans">

        <div class="bg-[#83218F] pt-12 pb-24 px-6 relative rounded-b-[3rem] shadow-md overflow-hidden">
            
            <div class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -ml-10 -mb-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>

            <div class="flex justify-between items-start relative z-10">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Selamat Datang,</p>
                    <h1 class="text-white font-bold text-2xl leading-tight">{{ Auth::user()->name }}</h1>
                    <span class="inline-block mt-2 px-3 py-1 bg-white/20 text-white text-[10px] font-bold rounded-full uppercase tracking-wider backdrop-blur-sm border border-white/10">
                        @if(Auth::user()->profile && Auth::user()->profile->nia_ipnu)
                            Kader Resmi
                        @else
                            Anggota Baru
                        @endif
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-3 bg-white/10 backdrop-blur-md rounded-xl text-white hover:bg-white/20 transition shadow-sm border border-white/10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="px-6 -mt-16 relative z-20">
            <div class="bg-white rounded-2xl shadow-lg p-4 flex justify-between items-center text-center divide-x divide-gray-100">
                
                <div class="flex-1 px-2">
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ \App\Models\Registration::where('phone', Auth::user()->profile->phone ?? '')->count() }}
                    </h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Kegiatan</p>
                </div>

                <div class="flex-1 px-2">
                    <h3 class="text-xl font-bold text-gray-800">
                        {{ \App\Models\Registration::where('phone', Auth::user()->profile->phone ?? '')->whereNotNull('presence_at')->count() }}
                    </h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Hadir</p>
                </div>

                <div class="flex-1 px-2">
                    @if(Auth::user()->profile && Auth::user()->profile->nia_ipnu)
                         <span class="text-[#83218F] text-xl">✔</span>
                    @else
                         <span class="text-gray-300 text-xl">-</span>
                    @endif
                    <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Verifikasi</p>
                </div>
            </div>
        </div>

        <div class="mt-6 px-6">
            <div class="bg-white rounded-3xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-gray-800 font-bold text-base">Menu Utama</h2>
                    <span class="text-[10px] bg-purple-50 text-[#83218F] px-2 py-1 rounded">Akses Cepat</span>
                </div>

                <div class="grid grid-cols-4 gap-y-8 gap-x-4">
                    
                    <a href="{{ route('biodata.edit') }}" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-[#83218F]/5 text-[#83218F] rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-[#83218F] group-hover:text-white transition-all duration-300 border border-[#83218F]/10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Biodata</span>
                    </a>

                    <a href="{{ route('my-events.index') }}" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-fuchsia-50 text-fuchsia-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-fuchsia-600 group-hover:text-white transition-all duration-300 border border-fuchsia-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Kegiatan</span>
                    </a>

                    <a href="{{ route('member.attendance.index') }}" class="flex flex-col items-center group">
    <div class="w-14 h-14 bg-purple-50 text-purple-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-purple-500 group-hover:text-white transition-all duration-300 border border-purple-100">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
    </div>
    <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Absensi</span>
</a>

                    <button onclick="alert('E-KTA Sedang diproses!')" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-violet-50 text-violet-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-violet-500 group-hover:text-white transition-all duration-300 border border-violet-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">E-KTA</span>
                    </button>

                    <button onclick="alert('Menu Kas belum tersedia')" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-pink-50 text-pink-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-pink-500 group-hover:text-white transition-all duration-300 border border-pink-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Kas</span>
                    </button>

                    <a href="{{ route('member.articles.index') }}" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-indigo-50 text-indigo-500 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300 border border-indigo-100">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Artikel</span>
                    </a>
                    
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center group">
                        <div class="w-14 h-14 bg-gray-100 text-gray-600 rounded-2xl flex items-center justify-center shadow-sm group-hover:bg-gray-600 group-hover:text-white transition-all duration-300 border border-gray-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="text-[11px] font-medium text-gray-600 mt-2 text-center">Akun</span>
                    </a>

                </div>
            </div>
        </div>

        <div class="mt-6 px-6">
            <h2 class="text-gray-800 font-bold text-base mb-4">Aktivitas Terkini</h2>
            
            @php
                $latestEvents = \App\Models\Event::where('status', 'open')->latest()->take(3)->get();
            @endphp

            @forelse($latestEvents as $event)
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-4 flex items-center gap-4 active:scale-95 transition transform cursor-pointer" onclick="window.location='{{ route('event.register', $event->id) }}'">
                <div class="w-14 h-14 bg-[#83218F]/10 rounded-xl flex-shrink-0 flex items-center justify-center text-[#83218F] font-bold text-xs overflow-hidden">
                    @if($event->banner)
                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-full object-cover">
                    @else
                        IPNU
                    @endif
                </div>
                
                <div class="flex-1">
                    <h3 class="font-bold text-sm text-gray-800">{{ Str::limit($event->title, 40) }}</h3>
                    <div class="flex items-center text-xs text-gray-400 mt-1">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $event->start_time->format('d M Y') }}
                    </div>
                </div>

                <div class="text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
            @empty
            <div class="text-center py-6 text-gray-400 text-sm bg-white rounded-2xl border border-dashed border-gray-200">
                Belum ada kegiatan terbaru.
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>