<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-[#83218F] font-sans pb-12">
        
        <div class="pt-6 px-4 mb-4">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <a href="{{ route('member.attendance.index') }}" class="p-2 bg-white/20 rounded-xl text-white hover:bg-white/30 transition backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-white font-bold text-lg">Tiket Absensi</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="bg-gray-50 rounded-t-[2.5rem] min-h-[85vh] px-6 pt-10 pb-20 relative">
            
            <div class="absolute -top-3 left-0 w-6 h-6 bg-[#83218F] rounded-full translate-y-1/2 -translate-x-1/2"></div>
            <div class="absolute -top-3 right-0 w-6 h-6 bg-[#83218F] rounded-full translate-y-1/2 translate-x-1/2"></div>
            
            <div class="bg-white rounded-3xl shadow-xl p-8 text-center border border-gray-100 mb-8 max-w-sm mx-auto">
                <h2 class="text-gray-800 font-bold text-lg leading-tight mb-1">{{ $registration->event->title }}</h2>
                <p class="text-xs text-gray-400 mb-6">{{ $registration->event->start_time->format('d F Y') }} • {{ $registration->event->location }}</p>
                
                <div class="flex justify-center mb-6">
                    <div class="p-3 border-2 border-dashed border-purple-200 rounded-2xl bg-purple-50">
                        {!! $qrcode !!}
                    </div>
                </div>

                @if($registration->presence_at)
                    <div class="bg-green-100 text-green-700 px-4 py-3 rounded-xl flex items-center justify-center gap-2 animate-pulse">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="text-left">
                            <p class="text-[10px] font-bold uppercase tracking-wider">Status</p>
                            <p class="text-sm font-bold">SUDAH HADIR</p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2">Check-in: {{ \Carbon\Carbon::parse($registration->presence_at)->format('H:i') }} WIB</p>
                @else
                    <div class="bg-yellow-50 text-yellow-700 px-4 py-3 rounded-xl flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        <div class="text-left">
                            <p class="text-[10px] font-bold uppercase tracking-wider">Status</p>
                            <p class="text-sm font-bold">BELUM SCAN</p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2">Tunjukkan QR ini ke panitia untuk absensi.</p>
                @endif
            </div>

            <div class="flex items-center gap-4 mb-6">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Rundown Acara</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <div class="space-y-0 relative border-l-2 border-purple-100 ml-3">
                @forelse($registration->event->schedules as $schedule)
                <div class="mb-6 ml-6 relative">
                    <span class="absolute -left-[31px] top-1 flex items-center justify-center w-4 h-4 bg-white border-2 border-[#83218F] rounded-full"></span>
                    
                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-800 text-sm">{{ $schedule->activity }}</h4>
                            <span class="text-[10px] font-bold bg-purple-50 text-[#83218F] px-2 py-0.5 rounded">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                            </span>
                        </div>
                        @if($schedule->pic)
                            <p class="text-xs text-gray-500">PIC: {{ $schedule->pic }}</p>
                        @endif
                    </div>
                </div>
                @empty
                <div class="ml-6 text-gray-400 text-xs italic">
                    Jadwal belum tersedia.
                </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>