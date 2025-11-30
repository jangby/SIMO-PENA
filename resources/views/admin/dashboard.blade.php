<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="text-gray-500 text-sm mt-1">Berikut adalah ringkasan aktivitas organisasi hari ini.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="bg-white border border-gray-200 text-gray-600 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-600 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Kader</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKader }}</h3>
            </div>
            <div class="bg-green-50 p-3 rounded-full text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500 flex items-center justify-between hover:shadow-md transition cursor-pointer" onclick="window.location='{{ route('admin.registrations.index') }}'">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Permintaan Baru</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingRequests }}</h3>
                <p class="text-[10px] text-red-500 font-semibold mt-1">Butuh Verifikasi</p>
            </div>
            <div class="bg-red-50 p-3 rounded-full text-red-600 relative">
                @if($pendingRequests > 0)
                    <span class="absolute top-0 right-0 flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                    </span>
                @endif
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Kegiatan Buka</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $activeEvents }}</h3>
            </div>
            <div class="bg-blue-50 p-3 rounded-full text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Kegiatan</p>
                <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ $totalEvents }}</h3>
            </div>
            <div class="bg-yellow-50 p-3 rounded-full text-yellow-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                <h3 class="font-bold text-lg text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Anggota Terbaru
                </h3>
                <a href="{{ route('admin.members.index') }}" class="text-xs font-bold text-green-600 hover:text-green-800 hover:underline">LIHAT SEMUA</a>
            </div>
            
            <div class="p-4 space-y-3 flex-1 overflow-y-auto max-h-[400px]">
                @forelse($latestMembers as $member)
                <div class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 transition group border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-sm">
                            {{ substr($member->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-sm text-gray-800 group-hover:text-green-700 transition">{{ $member->name }}</p>
                            <div class="flex items-center text-xs text-gray-500 mt-0.5">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                {{ $member->profile->school_origin ?? 'Belum isi profil' }}
                            </div>
                        </div>
                    </div>
                    <span class="text-[10px] font-medium text-gray-400 bg-gray-100 px-2 py-1 rounded-full">
                        {{ $member->created_at->diffForHumans() }}
                    </span>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-sm">Belum ada anggota baru.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50 rounded-t-xl">
                <h3 class="font-bold text-lg text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Agenda Mendatang
                </h3>
                <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline">KELOLA</a>
            </div>

            <div class="p-4 space-y-4 flex-1">
                @forelse($upcomingEvents as $event)
                <div class="flex group">
                    <div class="flex-shrink-0 w-14 h-14 bg-blue-50 rounded-lg flex flex-col items-center justify-center text-blue-600 mr-4 border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition">
                        <span class="text-xs font-bold uppercase">{{ $event->start_time->format('M') }}</span>
                        <span class="text-xl font-bold">{{ $event->start_time->format('d') }}</span>
                    </div>
                    
                    <div class="flex-1 pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                        <div class="flex justify-between items-start">
                            <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $event->title }}</h4>
                            <span class="text-[10px] font-bold uppercase px-2 py-0.5 rounded {{ $event->type == 'makesta' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $event->type }}
                            </span>
                        </div>
                        <div class="flex items-center text-xs text-gray-500 mt-2 gap-4">
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $event->start_time->format('H:i') }} WIB
                            </span>
                            <span class="flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $event->location }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-40 text-gray-400 bg-gray-50 rounded-lg border border-dashed border-gray-200">
                    <svg class="w-10 h-10 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-sm">Tidak ada agenda dekat ini.</p>
                    <a href="{{ route('admin.events.create') }}" class="text-xs text-blue-600 font-bold mt-2 hover:underline">+ Buat Jadwal</a>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-admin-layout>