<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span class="text-gray-500">Kelola:</span> {{ $event->title }}
                </h2>
                
                <div class="flex flex-wrap items-center gap-3 mt-2">
                    <span class="text-sm text-gray-500 flex items-center bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">
                        <svg class="w-4 h-4 mr-1 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $event->start_time->format('d M Y') }}
                    </span>
                    <span class="text-sm text-gray-500 flex items-center bg-white px-2 py-1 rounded border border-gray-200 shadow-sm">
                        <svg class="w-4 h-4 mr-1 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->location }}
                    </span>
                    
                    @if($event->status == 'open')
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-green-100 text-green-700 text-[10px] font-bold uppercase rounded-full border border-green-200">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Pendaftaran Buka
                        </span>
                    @else
                        <span class="flex items-center gap-1.5 px-2 py-1 bg-red-100 text-red-700 text-[10px] font-bold uppercase rounded-full border border-red-200">
                            <span class="w-2 h-2 bg-red-500 rounded-full"></span> Pendaftaran Tutup
                        </span>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                
                <form action="{{ route('admin.events.status', $event->id) }}" method="POST">
                    @csrf @method('PATCH')
                    
                    @if($event->status == 'open')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="bg-red-50 border border-red-200 text-red-600 hover:bg-red-600 hover:text-white px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tutup Pendaftaran
                        </button>
                    @else
                        <input type="hidden" name="status" value="open">
                        <button type="submit" class="bg-green-50 border border-green-200 text-green-600 hover:bg-green-600 hover:text-white px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Buka Pendaftaran
                        </button>
                    @endif
                </form>

                <div class="h-8 w-px bg-gray-300"></div>

                <a href="{{ route('admin.events.index') }}" class="bg-white border border-gray-300 text-gray-500 px-4 py-2 rounded-xl font-bold text-xs hover:bg-gray-50 transition">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-blue-500 flex flex-col justify-between h-28 relative overflow-hidden">
                    <div class="absolute right-2 top-2 opacity-10 text-blue-500">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pendaftar</div>
                    <div class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</div>
                </div>
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-green-500 flex flex-col justify-between h-28 relative overflow-hidden">
                    <div class="absolute right-2 top-2 opacity-10 text-green-500">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Peserta Resmi</div>
                    <div class="text-3xl font-black text-green-600">{{ $stats['approved'] }}</div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-yellow-500 flex flex-col justify-between h-28 relative overflow-hidden">
                    <div class="absolute right-2 top-2 opacity-10 text-yellow-500">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-gray-500 text-xs font-bold uppercase tracking-wider">Perlu Verifikasi</div>
                    <div class="text-3xl font-black text-yellow-600">{{ $stats['pending'] }}</div>
                </div>

                @php 
                    $hadir = $event->registrations()->whereNotNull('presence_at')->count();
                @endphp
                <div class="bg-[#83218F] p-5 rounded-2xl shadow-lg shadow-purple-200 flex flex-col justify-between h-28 relative overflow-hidden text-white">
                    <div class="absolute right-2 top-2 opacity-20">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <div class="text-purple-200 text-xs font-bold uppercase tracking-wider">Kehadiran</div>
                    <div class="text-3xl font-black">{{ $hadir }}</div>
                </div>
            </div>

            <hr class="border-gray-200">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-lg transition duration-300 border border-gray-100 group h-full flex flex-col">
                    <div class="flex items-center mb-4">
                        <div class="bg-blue-50 p-3 rounded-xl text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-bold text-lg text-gray-800">Data Peserta</h3>
                    </div>
                    <p class="text-gray-500 text-sm mb-6 flex-1">Lihat detail peserta, verifikasi pendaftaran, export Excel, dan cetak ID Card.</p>
                    
                    <div class="grid grid-cols-1 gap-2">
                        <a href="{{ route('admin.events.participants', $event->id) }}" class="w-full text-center bg-blue-50 text-blue-700 py-2 rounded-lg text-sm font-bold hover:bg-blue-600 hover:text-white transition">
                            Buka Data Peserta
                        </a>
                        <a href="{{ route('admin.events.print.idcards', $event->id) }}" target="_blank" class="w-full text-center border border-blue-200 text-blue-600 py-2 rounded-lg text-sm font-bold hover:bg-blue-50 transition flex items-center justify-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
    Cetak ID Card Massal
</a>
                    </div>
                </div>

                <a href="{{ route('admin.events.schedules', $event->id) }}" class="block group h-full">
                    <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-lg transition duration-300 border border-gray-100 h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="bg-yellow-50 p-3 rounded-xl text-yellow-600 mr-4 group-hover:bg-yellow-500 group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Jadwal & Rundown</h3>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Atur susunan acara, materi, dan petugas agar tampil di aplikasi peserta.</p>
                        <span class="w-full block text-center bg-yellow-50 text-yellow-700 py-2 rounded-lg text-sm font-bold group-hover:bg-yellow-500 group-hover:text-white transition">
                            Kelola Jadwal
                        </span>
                    </div>
                </a>

                <a href="{{ route('admin.events.attendance', $event->id) }}" class="block group h-full">
                    <div class="bg-white rounded-2xl shadow-sm p-6 hover:shadow-lg transition duration-300 border border-gray-100 h-full flex flex-col">
                        <div class="flex items-center mb-4">
                            <div class="bg-purple-50 p-3 rounded-xl text-[#83218F] mr-4 group-hover:bg-[#83218F] group-hover:text-white transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800">Absensi Kehadiran</h3>
                        </div>
                        <p class="text-gray-500 text-sm mb-6 flex-1">Scan QR Code peserta untuk pencatatan kehadiran otomatis saat acara.</p>
                        <span class="w-full block text-center bg-purple-50 text-[#83218F] py-2 rounded-lg text-sm font-bold group-hover:bg-[#83218F] group-hover:text-white transition">
                            Buka Scanner
                        </span>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-admin-layout>