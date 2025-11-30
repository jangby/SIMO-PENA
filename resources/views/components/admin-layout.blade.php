<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ sidebarOpen: true }">
    
    <div class="flex h-screen overflow-hidden">
        
        <aside class="flex-shrink-0 transition-all duration-300 bg-[#83218F] text-white flex flex-col"
               :class="sidebarOpen ? 'w-64' : 'w-20'">
            
            <div class="h-16 flex items-center justify-center border-b border-[#6d1b77] bg-[#5a1763]">
                <span class="font-bold text-xl tracking-wider" x-show="sidebarOpen">SIMO IPNU</span>
                <span class="font-bold text-xl" x-show="!sidebarOpen">IPNU</span>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                <ul class="space-y-1 px-2">
                    
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span class="ml-3 font-medium" x-show="sidebarOpen">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.registrations.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.registrations.*') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
                            <div class="relative">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
                                @php $reqCount = \App\Models\Registration::where('status', 'pending')->count(); @endphp
                                @if($reqCount > 0)
                                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-1 rounded-full animate-pulse">{{ $reqCount }}</span>
                                @endif
                            </div>
                            <span class="ml-3 font-medium" x-show="sidebarOpen">Request Daftar</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.members.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.members.*') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="ml-3 font-medium" x-show="sidebarOpen">Data Anggota</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.events.index') }}" 
                           class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.events.*') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="ml-3 font-medium" x-show="sidebarOpen">Kegiatan / Acara</span>
                        </a>
                    </li>

                    <li>
    <a href="{{ route('admin.articles.index') }}" 
       class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.articles.*') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
        <span class="ml-3 font-medium" x-show="sidebarOpen">Artikel / Berita</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.galleries.index') }}" 
       class="flex items-center px-4 py-3 rounded-lg hover:bg-[#6d1b77] transition {{ request()->routeIs('admin.galleries.*') ? 'bg-[#6d1b77] border-l-4 border-yellow-400' : '' }}">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
        <span class="ml-3 font-medium" x-show="sidebarOpen">Dokumentasi</span>
    </a>
</li>
                </ul>
            </nav>

            <div class="p-4 border-t border-[#6d1b77]">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-purple-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="ml-3 font-bold" x-show="sidebarOpen">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>

                <div class="flex items-center">
                    <span class="text-gray-800 text-sm font-semibold mr-2">{{ Auth::user()->name }}</span>
                    <div class="h-8 w-8 rounded-full bg-purple-100 flex items-center justify-center text-[#83218F] font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if (isset($header))
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>