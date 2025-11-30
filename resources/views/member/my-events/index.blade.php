<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">
        <div class="bg-[#83218F] pt-8 pb-14 px-4 sticky top-0 z-10 shadow-md rounded-b-[2rem]">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 rounded-xl text-white hover:bg-white/20 transition backdrop-blur-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-white font-bold text-lg tracking-wide">Kegiatan Saya</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="px-4 -mt-6 relative z-20 max-w-xl mx-auto space-y-4">
            @forelse($myEvents as $reg)
            <a href="{{ route('my-events.show', $reg->id) }}" class="block bg-white rounded-3xl shadow-md p-4 border border-gray-100 hover:shadow-lg transition active:scale-95">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-16 h-16 bg-purple-50 rounded-2xl flex flex-col items-center justify-center text-[#83218F] border border-purple-100">
                        <span class="text-xs font-bold uppercase">{{ $reg->event->start_time->format('M') }}</span>
                        <span class="text-xl font-extrabold">{{ $reg->event->start_time->format('d') }}</span>
                    </div>
                    
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $reg->event->type == 'makesta' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                                {{ $reg->event->type }}
                            </span>
                            @if($reg->status == 'approved')
                                <span class="text-[10px] font-bold text-green-600 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Terdaftar
                                </span>
                            @else
                                <span class="text-[10px] font-bold text-yellow-600">Menunggu</span>
                            @endif
                        </div>
                        <h3 class="font-bold text-gray-800 mt-1 leading-snug">{{ $reg->event->title }}</h3>
                        <p class="text-xs text-gray-400 mt-1 truncate">{{ $reg->event->location }}</p>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <p class="text-gray-500 text-sm">Anda belum mengikuti kegiatan apapun.</p>
                <a href="{{ route('welcome') }}" class="text-[#83218F] font-bold text-sm mt-2 inline-block">Cari Kegiatan Baru</a>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>