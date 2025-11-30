<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">
        <div class="bg-[#83218F] pt-8 pb-14 px-4 sticky top-0 z-10 shadow-md rounded-b-[2rem]">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 rounded-xl text-white hover:bg-white/20 transition backdrop-blur-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-white font-bold text-lg tracking-wide">Pilih Kegiatan</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="px-4 -mt-6 relative z-20 max-w-xl mx-auto space-y-4">
            @forelse($events as $reg)
            <a href="{{ route('member.attendance.show', $reg->id) }}" class="block bg-white rounded-3xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition active:scale-95 group">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-14 h-14 bg-purple-50 rounded-2xl flex flex-col items-center justify-center text-[#83218F] group-hover:bg-[#83218F] group-hover:text-white transition">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-sm leading-snug">{{ $reg->event->title }}</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $reg->event->start_time->format('d M Y') }}</p>
                        
                        @if($reg->presence_at)
                            <span class="inline-block mt-2 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded">Sudah Hadir</span>
                        @else
                            <span class="inline-block mt-2 px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded">Belum Absen</span>
                        @endif
                    </div>
                    
                    <div class="text-gray-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-12">
                <p class="text-gray-500 text-sm">Tidak ada kegiatan aktif untuk absensi.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>