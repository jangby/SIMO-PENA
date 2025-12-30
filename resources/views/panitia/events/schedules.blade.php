<x-mobile-layout>
    <x-slot name="title">Rundown Acara</x-slot>

    <div class="mb-6 flex items-center gap-3">
        <a href="{{ route('panitia.event.show', $event->id) }}" class="bg-white p-2 rounded-full shadow-sm border border-gray-100 text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="font-bold text-lg text-gray-800">Jadwal Kegiatan</h2>
    </div>

    <div class="relative pl-4 border-l-2 border-purple-100 space-y-8 pb-20 ml-2">
        @forelse($schedules as $index => $schedule)
        <div class="relative">
            {{-- Dot Timeline --}}
            <div class="absolute -left-[25px] top-1 bg-white border-4 border-[#83218F] w-4 h-4 rounded-full"></div>
            
            <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 relative">
                <div class="flex justify-between items-start mb-2">
                    <span class="bg-purple-50 text-[#83218F] px-2 py-1 rounded-lg text-xs font-black">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                    </span>
                </div>
                
                <h3 class="font-bold text-gray-900 text-base mb-1">{{ $schedule->activity_name }}</h3>
                <p class="text-xs text-gray-500 leading-relaxed">{{ $schedule->pic ?? 'Penanggung Jawab: Panitia' }}</p>
                
                @if($schedule->description)
                <div class="mt-3 text-xs text-gray-600 bg-gray-50 p-3 rounded-xl border border-gray-100">
                    {{ $schedule->description }}
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white p-6 rounded-2xl shadow-sm text-center text-gray-400">
            Belum ada jadwal yang diatur.
        </div>
        @endforelse
    </div>
</x-mobile-layout>