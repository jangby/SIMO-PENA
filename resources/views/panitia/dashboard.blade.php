<x-mobile-layout>
    <x-slot name="title">Beranda</x-slot>

    {{-- Kartu Info --}}
    <div class="bg-gradient-to-br from-[#83218F] to-purple-700 rounded-3xl p-6 text-white shadow-xl mb-6">
        <h2 class="text-4xl font-black">{{ $activeEvents->count() }}</h2>
        <p class="text-purple-100 text-sm">Event Sedang Aktif</p>
    </div>

    <h3 class="font-bold text-gray-800 mb-3 ml-1">Pilih Event</h3>

    <div class="space-y-3">
        @forelse($activeEvents as $event)
        <a href="{{ route('panitia.event.show', $event->id) }}" class="block bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-center active:scale-95 transition">
            <div class="bg-purple-50 p-3 rounded-xl text-center min-w-[60px]">
                <div class="text-[10px] font-bold text-gray-500 uppercase">{{ $event->start_time->format('M') }}</div>
                <div class="text-xl font-black text-[#83218F]">{{ $event->start_time->format('d') }}</div>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-gray-800 line-clamp-1">{{ $event->title }}</h4>
                <div class="text-xs text-gray-500 mt-1">{{ $event->location }}</div>
            </div>
            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
        @empty
        <p class="text-center text-gray-400 py-10">Tidak ada event aktif.</p>
        @endforelse
    </div>
</x-mobile-layout>