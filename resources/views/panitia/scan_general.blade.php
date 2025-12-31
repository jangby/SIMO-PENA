<x-mobile-layout>
    <x-slot name="title">Pilih Event</x-slot>

    <div class="mb-6 text-center">
        <h2 class="font-bold text-gray-800 text-lg">Mulai Scanner</h2>
        <p class="text-xs text-gray-500">Silakan pilih event yang ingin Anda kelola.</p>
    </div>

    {{-- LIST EVENT AKTIF --}}
    <div class="space-y-4">
        @forelse($events as $event)
        <a href="{{ route('panitia.scan', ['event_id' => $event->id]) }}" class="block group relative overflow-hidden bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 hover:border-purple-200 transition active:scale-95">
            
            <div class="flex items-center gap-4 relative z-10">
                {{-- Tanggal --}}
                <div class="bg-purple-50 text-[#83218F] p-3 rounded-2xl text-center min-w-[65px] group-hover:bg-[#83218F] group-hover:text-white transition duration-300">
                    <span class="block text-[10px] font-bold uppercase tracking-wider">{{ $event->start_time->format('M') }}</span>
                    <span class="block text-2xl font-black leading-none">{{ $event->start_time->format('d') }}</span>
                </div>

                {{-- Info Event --}}
                <div class="flex-1">
                    <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2 group-hover:text-purple-700 transition">{{ $event->title }}</h3>
                    <div class="flex items-center text-xs text-gray-500 gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->location }}
                    </div>
                </div>

                {{-- Icon Panah --}}
                <div class="bg-gray-50 p-2 rounded-full text-gray-400 group-hover:bg-purple-100 group-hover:text-purple-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>

            {{-- Hiasan Background --}}
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-purple-50 rounded-full blur-2xl opacity-0 group-hover:opacity-50 transition duration-500"></div>
        </a>
        @empty
        <div class="text-center py-12 bg-white rounded-[2rem] border border-dashed border-gray-200">
            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <p class="text-gray-400 text-sm font-medium">Tidak ada event aktif.</p>
        </div>
        @endforelse
    </div>

</x-mobile-layout>