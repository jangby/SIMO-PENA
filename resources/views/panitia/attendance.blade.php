<x-mobile-layout>
    <x-slot name="title">Rekap Absensi</x-slot>

    {{-- Header & PDF Download --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-gray-800">Data Kehadiran</h2>
        @if(request('event_id'))
        <a href="{{ route('panitia.event.export_pdf', request('event_id')) }}" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1 hover:bg-red-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            PDF Rekap
        </a>
        @endif
    </div>

    {{-- Tabs Navigasi --}}
    <div class="flex p-1 bg-gray-200 rounded-xl mb-6" x-data>
        <button @click="$dispatch('switch-tab', 'checkin')" 
                :class="$store.tabs.current === 'checkin' ? 'bg-white text-[#83218F] shadow-sm' : 'text-gray-500 hover:text-gray-700'" 
                class="flex-1 py-2.5 rounded-lg text-xs font-bold transition duration-200">
            Daftar Ulang (Live)
        </button>
        <button @click="$dispatch('switch-tab', 'materi')" 
                :class="$store.tabs.current === 'materi' ? 'bg-white text-[#83218F] shadow-sm' : 'text-gray-500 hover:text-gray-700'" 
                class="flex-1 py-2.5 rounded-lg text-xs font-bold transition duration-200">
            Per Materi
        </button>
    </div>

    {{-- Setup Alpine Store untuk Tabs --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('tabs', {
                current: 'checkin'
            });
        });
        window.addEventListener('switch-tab', event => {
            Alpine.store('tabs').current = event.detail;
        });
    </script>

    {{-- CONTAINER KONTEN --}}
    <div x-data> 
        
        {{-- ================= TAB 1: DAFTAR ULANG (LIVE LOG) ================= --}}
        <div x-show="$store.tabs.current === 'checkin'" x-transition.opacity.duration.300ms class="space-y-3">
             @if(!request('event_id'))
                <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm">Silakan masuk ke detail event untuk melihat data.</p>
                </div>
             @else
                 {{-- Info: Tab ini sengaja tidak dipisah IPNU/IPPNU karena sifatnya Log Kronologis (Siapa yang baru datang) --}}
                 @forelse($attendees as $a)
                 <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                     <div class="flex items-center gap-3">
                         {{-- Avatar Warna-warni Gender --}}
                         @php
                            $bgAvatar = $a->gender == 'L' ? 'bg-blue-50 text-blue-600' : 'bg-pink-50 text-pink-600';
                         @endphp
                         <div class="w-8 h-8 rounded-full {{ $bgAvatar }} flex items-center justify-center font-bold text-xs">
                             {{ substr($a->name, 0, 1) }}
                         </div>
                         <div>
                             <h4 class="font-bold text-sm text-gray-800 line-clamp-1">{{ $a->name }}</h4>
                             <p class="text-[10px] text-gray-500 line-clamp-1">{{ $a->school_origin }}</p>
                         </div>
                     </div>
                     <div class="text-right">
                         <span class="text-[10px] bg-green-100 text-green-700 px-2 py-1 rounded-md font-bold">
                             {{ \Carbon\Carbon::parse($a->presence_at)->format('H:i') }}
                         </span>
                     </div>
                 </div>
                 @empty
                 <div class="text-center py-8 text-gray-400">Belum ada peserta daftar ulang.</div>
                 @endforelse
                 
                 <div class="mt-4 px-2">{{ $attendees->withQueryString()->links() }}</div>
            @endif
        </div>

        {{-- ================= TAB 2: PER MATERI (Accordion) ================= --}}
        <div x-show="$store.tabs.current === 'materi'" x-transition.opacity.duration.300ms class="pb-24">
            
            @if(empty($schedules) || count($schedules) == 0)
                <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm">Belum ada jadwal atau Event ID tidak ditemukan.</p>
                </div>
            @else
                {{-- Accordion Container --}}
                <div class="space-y-4">
                    @foreach($schedules as $sched)
                        @php
                            // 1. Ambil Data Hadir & Pisah Gender
                            $hadir = $sched->attendances;
                            $hadirIpnu = $hadir->filter(fn($item) => $item->registration->gender == 'L');
                            $hadirIppnu = $hadir->filter(fn($item) => $item->registration->gender == 'P');

                            // 2. Ambil Data Belum & Pisah Gender
                            $presentIds = $hadir->pluck('registration_id')->toArray();
                            $absentAll = $allParticipants->whereNotIn('id', $presentIds);
                            
                            $absentIpnu = $absentAll->where('gender', 'L');
                            $absentIppnu = $absentAll->where('gender', 'P');

                            // 3. Status Waktu
                            $currentTime = \Carbon\Carbon::now();
                            $endTime = \Carbon\Carbon::parse($sched->end_time);
                            $isExpired = $currentTime->greaterThan($endTime);
                        @endphp

                        <div x-data="{ expanded: false }" class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
                            
                            {{-- HEAD (JUDUL MATERI) --}}
                            <div class="w-full flex justify-between items-center bg-white border-b border-gray-50 p-4">
                                <button @click="expanded = !expanded" class="flex-1 text-left flex items-center gap-3">
                                    {{-- Jam --}}
                                    <div class="flex flex-col items-center justify-center bg-gray-50 rounded-lg p-2 min-w-[50px]">
                                        <span class="text-[10px] font-bold text-gray-500 uppercase">MULAI</span>
                                        <span class="text-sm font-black text-[#83218F]">
                                            {{ \Carbon\Carbon::parse($sched->start_time)->format('H:i') }}
                                        </span>
                                    </div>

                                    {{-- Judul --}}
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-1">{{ $sched->activity }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] bg-purple-50 text-purple-600 px-2 py-0.5 rounded-full font-bold">
                                                Hadir: {{ $hadir->count() }}
                                            </span>
                                            {{-- Status --}}
                                            @if($isExpired)
                                                <span class="text-[10px] text-red-400 font-bold">Selesai</span>
                                            @elseif(\Carbon\Carbon::now()->between($sched->start_time, $sched->end_time))
                                                <span class="text-[10px] text-green-500 font-bold animate-pulse">Berlangsung</span>
                                            @endif
                                        </div>
                                    </div>
                                </button>

                                {{-- PDF PER MATERI --}}
                                <a href="{{ route('panitia.schedule.export_pdf', $sched->id) }}" class="ml-2 bg-red-50 text-red-600 p-2.5 rounded-xl hover:bg-red-100 transition shadow-sm border border-red-100" title="PDF Absensi Materi Ini">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                </a>

                                <button @click="expanded = !expanded" class="ml-2 text-gray-300 p-2">
                                    <svg class="w-5 h-5 transform transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </div>

                            {{-- BODY (DAFTAR HADIR) --}}
                            <div x-show="expanded" x-collapse class="bg-gray-50 p-4 space-y-6">

                                {{-- ===== 1. BAGIAN SUDAH HADIR ===== --}}
                                <div>
                                    <h4 class="text-xs font-bold text-green-700 uppercase tracking-wider mb-2 flex items-center gap-2">
                                        <span class="w-2 h-2 bg-green-500 rounded-full"></span> Sudah Hadir
                                    </h4>
                                    
                                    {{-- List IPNU Hadir --}}
                                    @if($hadirIpnu->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded mb-1 inline-block">IPNU ({{ $hadirIpnu->count() }})</span>
                                            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                                                @foreach($hadirIpnu as $att)
                                                    <div class="p-2.5 flex justify-between items-center">
                                                        <span class="text-xs font-medium text-gray-700 w-2/3 truncate">{{ $att->registration->name }}</span>
                                                        <span class="text-[10px] font-mono text-gray-400">{{ \Carbon\Carbon::parse($att->scanned_at)->format('H:i') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- List IPPNU Hadir --}}
                                    @if($hadirIppnu->count() > 0)
                                        <div>
                                            <span class="text-[10px] font-bold bg-pink-100 text-pink-700 px-2 py-0.5 rounded mb-1 inline-block">IPPNU ({{ $hadirIppnu->count() }})</span>
                                            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                                                @foreach($hadirIppnu as $att)
                                                    <div class="p-2.5 flex justify-between items-center">
                                                        <span class="text-xs font-medium text-gray-700 w-2/3 truncate">{{ $att->registration->name }}</span>
                                                        <span class="text-[10px] font-mono text-gray-400">{{ \Carbon\Carbon::parse($att->scanned_at)->format('H:i') }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if($hadir->count() == 0)
                                        <div class="p-3 text-center text-xs text-gray-400 italic bg-white rounded-xl border border-gray-200">Belum ada peserta hadir.</div>
                                    @endif
                                </div>


                                {{-- ===== 2. BAGIAN BELUM HADIR ===== --}}
                                <div>
                                    <h4 class="text-xs font-bold {{ $isExpired ? 'text-red-700' : 'text-orange-600' }} uppercase tracking-wider mb-2 flex items-center gap-2 border-t pt-4">
                                        <span class="w-2 h-2 {{ $isExpired ? 'bg-red-500' : 'bg-orange-400' }} rounded-full"></span> 
                                        {{ $isExpired ? 'Tidak Hadir (Alpha)' : 'Belum Scan' }}
                                    </h4>

                                    {{-- List IPNU Belum --}}
                                    @if($absentIpnu->count() > 0)
                                        <div class="mb-3">
                                            <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded mb-1 inline-block">IPNU ({{ $absentIpnu->count() }})</span>
                                            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100 max-h-40 overflow-y-auto">
                                                @foreach($absentIpnu as $absent)
                                                    <div class="p-2.5 flex justify-between items-center">
                                                        <span class="text-xs font-medium text-gray-700 truncate">{{ $absent->name }}</span>
                                                        @if($isExpired)
                                                            <span class="text-[9px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">ALFA</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- List IPPNU Belum --}}
                                    @if($absentIppnu->count() > 0)
                                        <div>
                                            <span class="text-[10px] font-bold bg-pink-100 text-pink-700 px-2 py-0.5 rounded mb-1 inline-block">IPPNU ({{ $absentIppnu->count() }})</span>
                                            <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100 max-h-40 overflow-y-auto">
                                                @foreach($absentIppnu as $absent)
                                                    <div class="p-2.5 flex justify-between items-center">
                                                        <span class="text-xs font-medium text-gray-700 truncate">{{ $absent->name }}</span>
                                                        @if($isExpired)
                                                            <span class="text-[9px] font-bold text-red-600 bg-red-50 px-1.5 py-0.5 rounded">ALFA</span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    @if($absentAll->count() == 0)
                                        <div class="p-3 text-center text-xs text-green-600 font-bold bg-white rounded-xl border border-gray-200">Semua Peserta Hadir!</div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-mobile-layout>