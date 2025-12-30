<x-mobile-layout>
    <x-slot name="title">Data Peserta</x-slot>

    <div class="mb-4 flex items-center gap-3">
        <a href="{{ route('panitia.event.show', $event->id) }}" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="font-bold text-lg text-gray-800">Daftar Peserta</h2>
    </div>

    {{-- FORM PENCARIAN --}}
    <form method="GET" class="mb-6">
        <div class="relative">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..." 
                   class="w-full pl-11 pr-4 py-3 rounded-2xl border-none bg-white shadow-sm focus:ring-2 focus:ring-[#83218F] text-sm text-gray-700">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </form>

    {{-- LIST PESERTA --}}
    <div class="space-y-3 pb-20">
        @forelse($participants as $p)
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm flex-shrink-0">
                    {{ substr($p->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-gray-800 text-sm truncate">{{ $p->name }}</h3>
                    <p class="text-[10px] text-gray-500 truncate">{{ $p->school_origin }}</p>
                </div>
            </div>
            
            @if($p->presence_at)
                <span class="px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold rounded-lg whitespace-nowrap">
                    Hadir
                </span>
            @else
                <span class="px-2 py-1 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-lg whitespace-nowrap">
                    Belum
                </span>
            @endif
        </div>
        @empty
        <div class="text-center py-10">
            <p class="text-gray-400 text-sm">Peserta tidak ditemukan.</p>
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $participants->links() }} 
        </div>
    </div>
</x-mobile-layout>