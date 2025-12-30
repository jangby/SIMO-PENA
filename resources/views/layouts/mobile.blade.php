<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Panitia Area' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        body { -webkit-tap-highlight-color: transparent; }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
    
    {{-- Frame HP (Maksimal Lebar 480px) --}}
    <div class="max-w-[480px] mx-auto min-h-screen bg-gray-50 relative shadow-2xl border-x border-gray-200 flex flex-col">
        
        {{-- Header --}}
        <header class="bg-[#83218F] text-white pt-8 pb-6 px-6 sticky top-0 z-40 rounded-b-[2rem] shadow-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="font-black text-xl tracking-tight">{{ $title ?? 'Panitia App' }}</h1>
                    <p class="text-xs text-purple-200 mt-1">Halo, {{ Auth::user()->name }} 👋</p>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white/20 p-2 rounded-full hover:bg-white/30 backdrop-blur-sm transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </form>
            </div>
        </header>

        {{-- Konten Utama --}}
        <main class="flex-1 p-5 pb-28 overflow-y-auto no-scrollbar">
            {{ $slot }}
        </main>

        {{-- Menu Bawah (Bottom Nav) --}}
        <nav class="fixed bottom-0 w-full max-w-[480px] bg-white border-t border-gray-100 flex justify-around items-end pb-4 pt-3 z-50 shadow-[0_-10px_40px_-15px_rgba(0,0,0,0.1)] rounded-t-[2rem]">
            
            <a href="{{ route('panitia.dashboard') }}" class="group flex flex-col items-center gap-1 w-1/3 {{ request()->routeIs('panitia.dashboard') ? 'text-[#83218F]' : 'text-gray-400' }}">
                <div class="p-1.5 rounded-xl transition {{ request()->routeIs('panitia.dashboard') ? 'bg-purple-50' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <span class="text-[10px] font-bold">Beranda</span>
            </a>

            {{-- Tombol Scan Besar --}}
            <a href="{{ route('panitia.scan') }}" class="relative -top-6 group w-1/3 flex justify-center">
                <div class="absolute bg-[#83218F] p-4 rounded-2xl shadow-xl shadow-purple-300 border-[6px] border-gray-50 transform transition group-active:scale-95">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
            </a>

            <a href="{{ route('panitia.attendance') }}" class="group flex flex-col items-center gap-1 w-1/3 {{ request()->routeIs('panitia.attendance') ? 'text-[#83218F]' : 'text-gray-400' }}">
                <div class="p-1.5 rounded-xl transition {{ request()->routeIs('panitia.attendance') ? 'bg-purple-50' : '' }}">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="text-[10px] font-bold">Data Absen</span>
            </a>

        </nav>
    </div>
</body>
</html>