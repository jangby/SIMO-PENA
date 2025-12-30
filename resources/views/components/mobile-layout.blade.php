<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panitia Area' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Sembunyikan scrollbar tapi tetap bisa scroll */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        /* Hilangkan highlight biru saat tap di Android */
        body { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
    
    {{-- Container HP (Max Width 480px) --}}
    <div class="max-w-[480px] mx-auto min-h-screen bg-gray-50 relative shadow-2xl border-x border-gray-200 flex flex-col overflow-hidden">
        
        {{-- Header dengan Gradient --}}
        <header class="bg-gradient-to-br from-[#83218F] to-purple-800 text-white pt-8 pb-6 px-6 sticky top-0 z-40 rounded-b-[2.5rem] shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="font-black text-xl tracking-tight">{{ $title ?? 'Panitia App' }}</h1>
                    <p class="text-xs text-purple-200 mt-0.5 font-medium">Halo, {{ Auth::user()->name }} 👋</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white/10 border border-white/20 p-2.5 rounded-full hover:bg-white/30 backdrop-blur-md transition active:scale-90 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        {{-- Konten Utama --}}
        <main class="flex-1 p-5 pb-32 overflow-y-auto no-scrollbar relative z-0">
            {{ $slot }}
        </main>

        {{-- BOTTOM NAVIGATION (Modern Floating Style) --}}
        <nav class="fixed bottom-0 w-full max-w-[480px] z-50">
            
            {{-- Gradient Fade di belakang menu agar konten yang di-scroll terlihat memudar --}}
            <div class="absolute bottom-0 w-full h-24 bg-gradient-to-t from-gray-100 via-gray-50/90 to-transparent pointer-events-none"></div>

            {{-- Navbar Container --}}
            <div class="relative bg-white/90 backdrop-blur-xl border-t border-white/50 px-8 py-3 pb-8 rounded-t-[2.5rem] shadow-[0_-10px_40px_-10px_rgba(0,0,0,0.08)] flex justify-between items-end">

                {{-- 1. BERANDA --}}
                <a href="{{ route('panitia.dashboard') }}" class="group flex flex-col items-center gap-1 w-1/3 transition duration-300">
                    <div class="p-2 rounded-2xl transition duration-300 group-active:scale-90 {{ request()->routeIs('panitia.dashboard') ? 'bg-purple-50 text-[#83218F]' : 'text-gray-400 hover:text-gray-600' }}">
                        @if(request()->routeIs('panitia.dashboard'))
                            {{-- Icon Solid (Aktif) --}}
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        @else
                            {{-- Icon Outline (Tidak Aktif) --}}
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold {{ request()->routeIs('panitia.dashboard') ? 'text-[#83218F]' : 'text-gray-400' }}">Beranda</span>
                </a>

                {{-- 2. TOMBOL SCAN (Floating Action Button) --}}
                <div class="relative w-1/3 flex justify-center group z-10">
                    <a href="{{ route('panitia.scan') }}" class="absolute -top-12 transform transition duration-300 group-active:scale-90 group-hover:-translate-y-1">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#83218F] to-purple-600 flex items-center justify-center text-white shadow-xl shadow-purple-200 border-[5px] border-gray-50 ring-1 ring-gray-100">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                    </a>
                    <span class="mt-8 text-[10px] font-bold text-gray-400 group-hover:text-purple-600 transition">Scan QR</span>
                </div>

                {{-- 3. ABSENSI --}}
                <a href="{{ route('panitia.attendance') }}" class="group flex flex-col items-center gap-1 w-1/3 transition duration-300">
                    <div class="p-2 rounded-2xl transition duration-300 group-active:scale-90 {{ request()->routeIs('panitia.attendance') ? 'bg-purple-50 text-[#83218F]' : 'text-gray-400 hover:text-gray-600' }}">
                        @if(request()->routeIs('panitia.attendance'))
                            {{-- Icon Solid (Aktif) --}}
                            <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                        @else
                            {{-- Icon Outline (Tidak Aktif) --}}
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold {{ request()->routeIs('panitia.attendance') ? 'text-[#83218F]' : 'text-gray-400' }}">Absensi</span>
                </a>

            </div>
        </nav>
    </div>
</body>
</html>