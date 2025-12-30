<x-mobile-layout>
    <x-slot name="title">Kontrol Event</x-slot>

    {{-- Tombol Kembali --}}
    <div class="mb-4">
        <a href="{{ route('panitia.dashboard') }}" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-[#83218F] transition uppercase tracking-wider">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali
        </a>
    </div>

    {{-- HEADER EVENT INFO --}}
    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 mb-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-6 -mt-6 w-32 h-32 bg-purple-50 rounded-full blur-2xl opacity-60"></div>
        
        <h2 class="font-black text-xl text-gray-800 leading-tight mb-2 relative z-10">{{ $event->title }}</h2>
        <div class="flex items-center gap-2 text-xs font-medium text-gray-500 mb-5 relative z-10">
            <svg class="w-4 h-4 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            {{ $event->location }}
        </div>

        {{-- STATUS ABSENSI --}}
        @php
            $percentage = $event->total_participants > 0 ? ($event->total_present / $event->total_participants) * 100 : 0;
        @endphp
        <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 relative z-10">
            <div class="flex justify-between items-end mb-2">
                <span class="text-xs font-bold text-gray-500 uppercase">Kehadiran</span>
                <span class="text-lg font-black text-[#83218F]">{{ $event->total_present }}<span class="text-sm text-gray-400 font-medium">/{{ $event->total_participants }}</span></span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-[#83218F] h-2.5 rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    </div>

    {{-- MENU GRID (4 TOMBOL UTAMA) --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        
        {{-- 1. SCAN QR --}}
        <a href="{{ route('panitia.scan', ['event_id' => $event->id]) }}" class="group bg-[#83218F] text-white p-5 rounded-[2rem] shadow-lg shadow-purple-200 flex flex-col items-center justify-center text-center relative overflow-hidden active:scale-95 transition min-h-[140px]">
            <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition"></div>
            <svg class="w-10 h-10 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            <span class="font-bold">Scan QR</span>
            <span class="text-[10px] text-purple-200 mt-1">Absensi Masuk</span>
        </a>

        {{-- 2. DATA PESERTA --}}
        <a href="{{ route('panitia.event.participants', $event->id) }}" class="group bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center active:scale-95 transition hover:border-purple-200 min-h-[140px]">
            <div class="bg-orange-50 p-3 rounded-full mb-3 text-orange-500 group-hover:bg-orange-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <span class="font-bold text-gray-800">Data Peserta</span>
            <span class="text-[10px] text-gray-400 mt-1">Cari & Lihat Detail</span>
        </a>

        {{-- 3. RUNDOWN --}}
        <a href="{{ route('panitia.event.schedules', $event->id) }}" class="group bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center active:scale-95 transition hover:border-purple-200 min-h-[140px]">
            <div class="bg-blue-50 p-3 rounded-full mb-3 text-blue-500 group-hover:bg-blue-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="font-bold text-gray-800">Rundown</span>
            <span class="text-[10px] text-gray-400 mt-1">Jadwal Acara</span>
        </a>

        {{-- 4. REKAP ABSEN --}}
        <a href="{{ route('panitia.attendance', ['event_id' => $event->id]) }}" class="group bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center active:scale-95 transition hover:border-purple-200 min-h-[140px]">
            <div class="bg-green-50 p-3 rounded-full mb-3 text-green-600 group-hover:bg-green-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <span class="font-bold text-gray-800">Rekap Absen</span>
            <span class="text-[10px] text-gray-400 mt-1">Data Kehadiran</span>
        </a>

    </div>

    {{-- RECENT LOG --}}
    <h3 class="font-bold text-gray-800 mb-4 ml-1 flex items-center gap-2 text-sm">
        <span>Aktivitas Terbaru</span>
    </h3>

    <div class="space-y-3">
        @forelse($recentPresences as $presence)
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-50 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-purple-50 text-[#83218F] flex items-center justify-center font-bold text-sm">
                {{ substr($presence->name, 0, 1) }}
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-sm text-gray-800 line-clamp-1">{{ $presence->name }}</h4>
                <p class="text-[10px] text-gray-500">Telah hadir pada {{ \Carbon\Carbon::parse($presence->presence_at)->format('H:i') }}</p>
            </div>
        </div>
        @empty
        <div class="text-center py-6 text-gray-400 text-xs italic">
            Belum ada aktivitas absensi.
        </div>
        @endforelse
    </div>

</x-mobile-layout>