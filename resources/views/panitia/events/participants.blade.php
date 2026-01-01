<x-mobile-layout>
    <x-slot name="title">Data Peserta</x-slot>

    {{-- HEADER --}}
    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('panitia.event.show', $event->id) }}" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 text-gray-600 active:scale-95 transition-transform">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="font-bold text-lg text-gray-800 leading-tight">Daftar Peserta</h2>
            <p class="text-[10px] text-gray-400">{{ $event->title }}</p>
        </div>
    </div>

    {{-- TOOLBAR (SEARCH + FILTER) --}}
    <form method="GET" class="mb-6">
        <div class="flex gap-2">
            {{-- Filter Gender --}}
            <div class="relative shrink-0">
                <select name="gender" onchange="this.form.submit()" class="appearance-none w-full pl-3 pr-8 py-3 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-[#83218F] text-sm text-gray-700 font-bold">
                    <option value="">Semua</option>
                    <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>IPNU</option>
                    <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>IPPNU</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>

            {{-- Input Pencarian --}}
            <div class="relative flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." 
                       class="w-full pl-10 pr-4 py-3 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-[#83218F] text-sm text-gray-700">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </form>

    {{-- LIST PESERTA --}}
    <div class="space-y-3 pb-20">
        @forelse($participants as $p)
        <div class="bg-white p-3 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                {{-- Avatar dengan Color Coding Gender --}}
                @php
                    $bgClass = 'bg-gray-100 text-gray-600'; // Default
                    if($p->gender == 'L') $bgClass = 'bg-blue-50 text-blue-600 border border-blue-100';
                    if($p->gender == 'P') $bgClass = 'bg-pink-50 text-pink-600 border border-pink-100';
                @endphp

                <div class="w-10 h-10 rounded-full {{ $bgClass }} flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm">
                    {{ substr($p->name, 0, 1) }}
                </div>
                
                <div class="min-w-0">
                    <h3 class="font-bold text-gray-800 text-sm truncate">{{ $p->name }}</h3>
                    <p class="text-[10px] text-gray-500 truncate flex items-center gap-1">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $p->school_origin }}
                    </p>
                </div>
            </div>
            
            {{-- Status Kehadiran --}}
            @if($p->presence_at)
                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg whitespace-nowrap flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Hadir
                </span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-lg whitespace-nowrap">
                    Belum
                </span>
            @endif
        </div>
        @empty
        <div class="flex flex-col items-center justify-center py-10">
            <div class="bg-gray-50 p-4 rounded-full mb-3">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <p class="text-gray-400 text-xs font-medium">Peserta tidak ditemukan.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4 px-2">
            {{ $participants->appends(request()->query())->links() }} 
        </div>
    </div>
</x-mobile-layout>