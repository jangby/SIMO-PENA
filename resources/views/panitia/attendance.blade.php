<x-mobile-layout>
    <x-slot name="title">Rekap Absensi</x-slot>

    {{-- Header & PDF Download --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-gray-800">Data Kehadiran</h2>
        @if(request('event_id'))
        <a href="{{ route('panitia.event.export_pdf', request('event_id')) }}" class="bg-red-50 text-red-600 border border-red-200 px-3 py-1.5 rounded-lg text-xs font-bold flex items-center gap-1 hover:bg-red-100 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            PDF
        </a>
        @endif
    </div>

    {{-- Tabs Navigasi --}}
    <div class="flex p-1 bg-gray-200 rounded-xl mb-6" x-data>
        <button @click="$dispatch('switch-tab', 'checkin')" 
                :class="$store.tabs.current === 'checkin' ? 'bg-white text-[#83218F] shadow-sm' : 'text-gray-500 hover:text-gray-700'" 
                class="flex-1 py-2.5 rounded-lg text-xs font-bold transition duration-200">
            Daftar Ulang
        </button>
        <button @click="$dispatch('switch-tab', 'materi')" 
                :class="$store.tabs.current === 'materi' ? 'bg-white text-[#83218F] shadow-sm' : 'text-gray-500 hover:text-gray-700'" 
                class="flex-1 py-2.5 rounded-lg text-xs font-bold transition duration-200">
            Per Materi
        </button>
    </div>

    {{-- Setup Alpine Store untuk Tabs (Biar rapi) --}}
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
        
        {{-- ================= TAB 1: DAFTAR ULANG ================= --}}
        <div x-show="$store.tabs.current === 'checkin'" x-transition.opacity.duration.300ms class="space-y-3">
             @if(!request('event_id'))
                <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm">Silakan masuk ke detail event untuk melihat data.</p>
                </div>
             @else
                 @forelse($attendees as $a)
                 <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex justify-between items-center">
                     <div class="flex items-center gap-3">
                         <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center font-bold text-xs">
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
                 
                 <div class="mt-4">{{ $attendees->links() }}</div>
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
                            // 1. Ambil ID Peserta yang HADIR di materi ini
                            $presentIds = $sched->attendances->pluck('registration_id')->toArray();
                            
                            // 2. Filter Peserta yang TIDAK HADIR
                            // (Dari semua peserta approved, ambil yg ID-nya tidak ada di $presentIds)
                            $absentParticipants = $allParticipants->whereNotIn('id', $presentIds);

                            // 3. Cek Waktu (Apakah materi sudah lewat?)
                            $currentTime = \Carbon\Carbon::now();
                            $endTime = \Carbon\Carbon::parse($sched->end_time); // Pastikan ini DateTime
                            $isExpired = $currentTime->greaterThan($endTime);

                            // Hitung Persentase
                            $total = $allParticipants->count();
                            $presentCount = count($presentIds);
                            $percent = $total > 0 ? round(($presentCount / $total) * 100) : 0;
                        @endphp

                        <div x-data="{ expanded: false }" class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden transition-all duration-300">
    
    {{-- HEAD (JUDUL MATERI) --}}
    <div class="w-full flex justify-between items-center bg-white border-b border-gray-50 p-4">
        
        {{-- Area Klik Accordion (Kiri) --}}
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
                        Hadir: {{ $sched->attendances->count() }}
                    </span>
                    {{-- Status Waktu --}}
                    @if(\Carbon\Carbon::now()->greaterThan($sched->end_time))
                        <span class="text-[10px] text-red-400 font-bold">Selesai</span>
                    @elseif(\Carbon\Carbon::now()->between($sched->start_time, $sched->end_time))
                        <span class="text-[10px] text-green-500 font-bold animate-pulse">Berlangsung</span>
                    @endif
                </div>
            </div>
        </button>

        {{-- TOMBOL DOWNLOAD PDF (Kanan) --}}
        <a href="{{ route('schedule.export_pdf', $sched->id) }}" class="ml-2 bg-red-50 text-red-600 p-2.5 rounded-xl hover:bg-red-100 transition shadow-sm border border-red-100" title="Download Absensi Materi Ini">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
        </a>

        {{-- Tombol Buka Tutup Accordion (Kecil) --}}
        <button @click="expanded = !expanded" class="ml-2 text-gray-300 p-2">
            <svg class="w-5 h-5 transform transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
        </button>
    </div>

    {{-- BODY (DAFTAR HADIR) --}}
    <div x-show="expanded" x-collapse class="bg-gray-50">
        {{-- ... (Isi tabel mini yang sudah kita buat sebelumnya tetap sama) ... --}}
        <div class="p-4 space-y-6">
            {{-- Paste ulang isi body accordion yang tadi (Bagian 'Sudah Hadir' & 'Belum Hadir') disini --}}
            {{-- Saya singkat agar tidak kepanjangan, pakai kode yang sebelumnya ya --}}
            
             {{-- BAGIAN 1: YANG SUDAH HADIR --}}
             <div>
                <h4 class="text-xs font-bold text-green-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full"></span> Sudah Hadir
                </h4>
                <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100">
                    @forelse($sched->attendances as $att)
                    <div class="p-3 flex justify-between items-center">
                        <span class="text-xs font-medium text-gray-700 w-2/3 truncate">{{ $att->registration->name ?? '-' }}</span>
                        <span class="text-[10px] font-mono text-gray-400 bg-gray-100 px-2 py-0.5 rounded">
                            {{ \Carbon\Carbon::parse($att->scanned_at)->format('H:i') }}
                        </span>
                    </div>
                    @empty
                    <div class="p-3 text-center text-xs text-gray-400 italic">Belum ada data.</div>
                    @endforelse
                </div>
            </div>

            {{-- BAGIAN 2: YANG BELUM --}}
            @php
                 $presentIds = $sched->attendances->pluck('registration_id')->toArray();
                 $absentParticipants = $allParticipants->whereNotIn('id', $presentIds);
                 $isExpired = \Carbon\Carbon::now()->greaterThan($sched->end_time);
            @endphp
            <div>
                <h4 class="text-xs font-bold {{ $isExpired ? 'text-red-700' : 'text-orange-600' }} uppercase tracking-wider mb-3 flex items-center gap-2 mt-4">
                    <span class="w-2 h-2 {{ $isExpired ? 'bg-red-500' : 'bg-orange-400' }} rounded-full"></span> 
                    {{ $isExpired ? 'Tidak Hadir' : 'Belum Scan' }}
                </h4>
                <div class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100 max-h-60 overflow-y-auto">
                    @forelse($absentParticipants as $absent)
                    <div class="p-3 flex justify-between items-center">
                        <span class="text-xs font-medium text-gray-700 truncate w-2/3">{{ $absent->name }}</span>
                        @if($isExpired)
                            <span class="text-[9px] font-bold text-red-600 bg-red-100 px-2 py-1 rounded">ALPHA</span>
                        @else
                            <span class="text-[9px] font-bold text-orange-500 bg-orange-100 px-2 py-1 rounded">BELUM</span>
                        @endif
                    </div>
                    @empty
                    <div class="p-3 text-center text-xs text-green-600 font-bold">Semua Hadir!</div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-mobile-layout>