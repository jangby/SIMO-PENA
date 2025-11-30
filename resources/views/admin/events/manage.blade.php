<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-gray-500">Kelola:</span> {{ $event->title }}
                </h2>
                <div class="flex items-center gap-3 mt-1">
                    <span class="text-sm text-gray-500 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $event->start_time->format('d M Y') }}
                    </span>
                    
                    @if($event->status == 'open')
                        <span class="flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded-full">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Pendaftaran Buka
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded-full">
                            Pendaftaran Tutup
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                
                <form action="{{ route('admin.events.status', $event->id) }}" method="POST">
                    @csrf @method('PATCH')
                    
                    @if($event->status == 'open')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-bold text-xs flex items-center shadow-sm transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            Tutup Pendaftaran
                        </button>
                    @else
                        <input type="hidden" name="status" value="open">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-bold text-xs flex items-center shadow-sm transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                            Buka Pendaftaran
                        </button>
                    @endif
                </form>

                <div class="h-8 w-px bg-gray-300 mx-1"></div>

                <a href="{{ route('admin.events.index') }}" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg font-bold text-xs hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Total Pendaftar</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                    <div class="text-xs text-gray-400">Orang</div>
                </div>
                
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Peserta Resmi</div>
                    <div class="text-2xl font-bold text-green-700">{{ $stats['approved'] }}</div>
                    <div class="text-xs text-gray-400">Siap Hadir</div>
                </div>

                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Menunggu Verifikasi</div>
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                    <div class="text-xs text-gray-400">Butuh Tindakan</div>
                </div>

                @php 
                    $hadir = $event->registrations()->whereNotNull('presence_at')->count();
                @endphp
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-purple-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Kehadiran (Check-in)</div>
                    <div class="text-2xl font-bold text-purple-700">{{ $hadir }}</div>
                    <div class="text-xs text-gray-400">Orang di lokasi</div>
                </div>
            </div>

            <hr class="border-gray-300">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('admin.events.participants', $event->id) }}" class="block group">
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1 border border-transparent hover:border-blue-300 h-full">
                        <div class="flex items-center mb-4">
                            <div class="bg-blue-100 p-3 rounded-full text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Data Peserta</h3>
                        </div>
                        <p class="text-gray-500 text-sm mb-4">Lihat detail peserta resmi, kontak WA, dan asal sekolah.</p>
                        <span class="text-blue-600 text-sm font-semibold group-hover:underline flex items-center">
                            Buka Data <span class="ml-1">&rarr;</span>
                        </span>
                    </div>
                </a>

                <a href="{{ route('admin.events.schedules', $event->id) }}" class="block group">
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1 border border-transparent hover:border-yellow-300 h-full">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-100 p-3 rounded-full text-yellow-600 mr-4 group-hover:bg-yellow-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Jadwal & Rundown</h3>
                        </div>
                        <p class="text-gray-500 text-sm mb-4">Atur susunan acara, jam materi, dan petugas/PIC kegiatan.</p>
                        <span class="text-yellow-600 text-sm font-semibold group-hover:underline flex items-center">
                            Kelola Jadwal <span class="ml-1">&rarr;</span>
                        </span>
                    </div>
                </a>

                <a href="{{ route('admin.events.attendance', $event->id) }}" class="block group">
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition transform hover:-translate-y-1 border border-transparent hover:border-purple-300 h-full">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-100 p-3 rounded-full text-purple-600 mr-4 group-hover:bg-purple-600 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Absensi Kehadiran</h3>
                        </div>
                        <p class="text-gray-500 text-sm mb-4">Catat kehadiran peserta secara manual (Check-in) saat hari H.</p>
                        <span class="text-purple-600 text-sm font-semibold group-hover:underline flex items-center">
                            Buka Absensi <span class="ml-1">&rarr;</span>
                        </span>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-admin-layout>