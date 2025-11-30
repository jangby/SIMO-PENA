<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Scrollbar Halus untuk Sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.4); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-slate-800" x-data="{ sidebarOpen: true }">
    
    <div class="flex h-screen overflow-hidden">
        
        <aside class="flex-shrink-0 transition-all duration-500 ease-in-out bg-gradient-to-b from-[#9d3cbd] to-[#83218F] text-white flex flex-col relative overflow-hidden shadow-2xl z-20"
               :class="sidebarOpen ? 'w-72' : 'w-24'">
            
            <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-overlay">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="smallGrid" width="8" height="8" patternUnits="userSpaceOnUse">
                            <path d="M 8 0 L 0 0 0 8" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#smallGrid)" />
                </svg>
            </div>
            
            <div class="absolute top-[-100px] left-[-100px] w-64 h-64 bg-white opacity-10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="h-24 flex items-center justify-center relative z-10 border-b border-white/10">
                <div class="flex items-center gap-3 transition-all duration-300" :class="sidebarOpen ? 'px-6' : 'px-0'">
                    <div class="relative group">
                         <div class="absolute -inset-2 bg-white/20 rounded-full blur-md opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <img src="{{ asset('logo/logopena.jpg') }}" class="relative h-11 w-11 object-contain drop-shadow-md bg-white/10 p-1 rounded-xl backdrop-blur-sm border border-white/20">
                    </div>
                    <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 -translate-x-5" x-transition:enter-end="opacity-100 translate-x-0">
                        <h1 class="font-extrabold text-xl tracking-tight leading-none text-white drop-shadow-sm">Pena</h1>
                        <p class="text-[10px] text-purple-100 font-bold tracking-widest uppercase">Admin Console</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll py-6 px-4 relative z-10 space-y-1.5">
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 relative overflow-hidden mb-2
                   {{ request()->routeIs('admin.dashboard') 
                        ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' 
                        : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    
                    <svg class="w-6 h-6 flex-shrink-0 transition-transform duration-300 group-hover:scale-110 drop-shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="ml-3 font-bold text-sm tracking-wide whitespace-nowrap" x-show="sidebarOpen">Dashboard</span>
                    
                    @if(request()->routeIs('admin.dashboard'))
                         <span class="absolute right-2 w-1.5 h-1.5 rounded-full bg-white shadow-glow animate-pulse" x-show="sidebarOpen"></span>
                    @endif
                </a>

                <div x-show="sidebarOpen" class="px-4 mb-2 mt-6 transition-opacity duration-500">
                    <p class="text-[10px] font-black text-purple-200/60 uppercase tracking-widest">Manajemen Data</p>
                </div>

                <a href="{{ route('admin.registrations.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.registrations.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <div class="relative">
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
                        @php $reqCount = \App\Models\Registration::where('status', 'pending')->count(); @endphp
                        @if($reqCount > 0)
                            <span class="absolute -top-2 -right-2 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 ring-2 ring-[#83218F] text-[9px] font-bold text-white">
                                {{ $reqCount }}
                            </span>
                        @endif
                    </div>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Permohonan</span>
                </a>

                <a href="{{ route('admin.members.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.members.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Database Kader</span>
                </a>

                <a href="{{ route('admin.structures.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden mb-1
                   {{ request()->routeIs('admin.structures.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Struktur Organisasi</span>
                </a>

                 <a href="{{ route('admin.events.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.events.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Event & Acara</span>
                </a>


                <div x-show="sidebarOpen" class="px-4 mb-2 mt-6">
                     <p class="text-[10px] font-black text-purple-200/60 uppercase tracking-widest">Konten & Publikasi</p>
                </div>

                <a href="{{ route('admin.articles.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.articles.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Berita / Artikel</span>
                </a>

                <a href="{{ route('admin.galleries.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.galleries.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">Galeri Foto</span>
                </a>

                <a href="{{ route('admin.letters.index') }}" 
                   class="group flex items-center px-4 py-3 rounded-2xl transition-all duration-300 relative overflow-hidden
                   {{ request()->routeIs('admin.letters.*') ? 'bg-white/25 text-white shadow-lg border border-white/20 backdrop-blur-md' : 'text-purple-100 hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="ml-3 font-semibold text-sm whitespace-nowrap" x-show="sidebarOpen">E-Arsip Surat</span>
                </a>

            </nav>

            <div class="relative z-10 border-t border-white/10 bg-[#6d1b77]/30 backdrop-blur-sm p-4">
                <div class="flex items-center gap-3" :class="sidebarOpen ? '' : 'justify-center'">
                    
                    <div class="relative flex-shrink-0 group">
                         <div class="absolute -inset-1 bg-white/30 rounded-full blur opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        <div class="w-10 h-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white font-bold text-sm relative">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>

                    <div class="flex-1 overflow-hidden" x-show="sidebarOpen">
                        <p class="text-sm font-bold text-white truncate leading-tight">{{ Auth::user()->name }}</p>
                         <a href="{{ route('profile.edit') }}" class="text-[10px] text-purple-200 hover:text-white transition flex items-center gap-1 mt-0.5 font-medium">
                             Pengaturan Akun
                        </a>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" x-show="sidebarOpen">
                        @csrf
                        <button type="submit" class="text-purple-200 hover:text-red-300 transition p-2 hover:bg-white/10 rounded-xl" title="Logout">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </aside>

        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 relative">
            
            <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 h-16 flex items-center justify-between px-6 z-10 sticky top-0">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-[#83218F] focus:outline-none transition-transform active:scale-90 p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                </button>

                <div class="flex items-center gap-4">
                     <span class="inline-flex items-center rounded-full bg-purple-50 px-3 py-1 text-xs font-bold text-[#83218F] ring-1 ring-inset ring-purple-600/20">
                        Mode Admin
                     </span>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-0 scroll-smooth">
                {{ $slot }}
            </main>
        </div>

    </div>
</body>
</html>