<x-admin-layout>
    <x-slot name="header"></x-slot>

    <div class="min-h-screen pb-12">

        <div class="relative bg-gradient-to-r from-[#9d3cbd] to-[#83218F] pb-32 pt-12 px-6 rounded-b-[3rem] shadow-xl overflow-hidden">
            
            <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-overlay">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="dashboardGrid" width="20" height="20" patternUnits="userSpaceOnUse">
                            <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#dashboardGrid)" />
                </svg>
            </div>

            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 bg-blue-400 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10 max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-white">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="bg-white/20 backdrop-blur-md border border-white/20 px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">
                            Admin Dashboard
                        </span>
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
                        </span>
                    </div>
                    <h1 class="text-4xl font-extrabold tracking-tight leading-tight">
                        Selamat Datang, <span class="text-yellow-300">{{ Auth::user()->name }}</span>
                    </h1>
                    <p class="text-purple-100 mt-2 text-sm max-w-lg opacity-90">
                        Kelola data kader, verifikasi pendaftaran, dan atur kegiatan organisasi dengan mudah dan efisien.
                    </p>
                </div>

                <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center text-white min-w-[140px] shadow-lg transform hover:scale-105 transition">
                    <div class="text-3xl font-black">{{ date('d') }}</div>
                    <div class="text-[10px] uppercase font-bold tracking-widest text-purple-200">{{ date('F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 -mt-20 relative z-20">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <div class="bg-white rounded-3xl p-6 shadow-lg border border-purple-50 group hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Kader</p>
                            <h3 class="text-3xl font-black text-gray-800 mt-1 group-hover:text-[#83218F] transition">{{ $totalKader }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-[#83218F] group-hover:bg-[#83218F] group-hover:text-white transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-green-600 bg-green-50 w-fit px-2 py-1 rounded-lg">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span>Data Aktif</span>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg border-l-4 border-red-500 hover:-translate-y-1 transition duration-300 relative overflow-hidden">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Permohonan Baru</p>
                            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $pendingRequests }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
                            @if($pendingRequests > 0)
                                <span class="absolute top-0 right-0 -mt-1 -mr-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-bounce"></span>
                            @endif
                        </div>
                    </div>
                    @if($pendingRequests > 0)
                        <a href="{{ route('admin.registrations.index') }}" class="mt-4 inline-flex items-center text-xs font-bold text-red-500 hover:underline relative z-10">
                            Verifikasi Sekarang &rarr;
                        </a>
                    @else
                        <span class="mt-4 block text-xs text-gray-400">Tidak ada pending.</span>
                    @endif
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg border border-blue-50 hover:-translate-y-1 transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Kegiatan Buka</p>
                            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $activeEvents }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4">Pendaftaran sedang berlangsung</p>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-lg border border-yellow-50 hover:-translate-y-1 transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider">Total Arsip</p>
                            <h3 class="text-3xl font-black text-gray-800 mt-1">{{ $totalEvents }}</h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-yellow-50 flex items-center justify-center text-yellow-500 group-hover:bg-yellow-500 group-hover:text-white transition shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-4">Seluruh kegiatan terlaksana</p>
                </div>

            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 mt-12 pb-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div>
                        <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Aksi Cepat
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.events.create') }}" class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#83218F] transition text-center">
                                <div class="w-10 h-10 bg-purple-50 text-[#83218F] rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-[#83218F] group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700">Buat Acara</span>
                            </a>
                            <a href="{{ route('admin.articles.create') }}" class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-500 transition text-center">
                                <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-500 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700">Tulis Berita</span>
                            </a>
                            <a href="{{ route('admin.galleries.create') }}" class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-pink-500 transition text-center">
                                <div class="w-10 h-10 bg-pink-50 text-pink-500 rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-pink-500 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700">Upload Foto</span>
                            </a>
                            <a href="{{ route('admin.members.export') }}" class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-green-500 transition text-center">
                                <div class="w-10 h-10 bg-green-50 text-green-500 rounded-xl flex items-center justify-center mx-auto mb-2 group-hover:bg-green-500 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4-4m4 4V4"></path></svg>
                                </div>
                                <span class="text-xs font-bold text-gray-700">Export Data</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-bold text-gray-800">Kader Terbaru</h3>
                            <a href="{{ route('admin.members.index') }}" class="text-xs font-bold text-[#83218F] hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-2">
                            @forelse($latestMembers as $member)
                            <div class="flex items-center justify-between p-3 hover:bg-purple-50 rounded-2xl transition group cursor-pointer" onclick="window.location='{{ route('admin.members.show', $member->id) }}'">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 rounded-full bg-purple-100 text-[#83218F] flex items-center justify-center font-bold text-sm">
                                        {{ substr($member->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-800 group-hover:text-[#83218F] transition">{{ $member->name }}</h4>
                                        <p class="text-[10px] text-gray-500">{{ $member->profile->school_origin ?? 'Belum ada data' }}</p>
                                    </div>
                                </div>
                                <span class="text-[10px] font-bold text-gray-400">{{ $member->created_at->diffForHumans() }}</span>
                            </div>
                            @empty
                            <div class="p-8 text-center text-gray-400 text-sm">Belum ada anggota baru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 h-full p-6">
                        <h3 class="font-bold text-gray-800 text-lg mb-6">Agenda Mendatang</h3>

                        <div class="space-y-6 relative border-l-2 border-dashed border-gray-200 ml-3">
                            @forelse($upcomingEvents as $event)
                            <div class="relative pl-6 group">
                                <span class="absolute -left-[7px] top-1 w-3 h-3 rounded-full bg-[#83218F] ring-4 ring-white group-hover:scale-125 transition"></span>
                                <a href="{{ route('admin.events.manage', $event->id) }}" class="block">
                                    <span class="text-[10px] font-bold uppercase text-[#83218F] mb-1 block">{{ $event->start_time->format('d M Y') }}</span>
                                    <h4 class="font-bold text-sm text-gray-800 group-hover:text-[#83218F] transition leading-snug">{{ $event->title }}</h4>
                                    <div class="flex items-center text-[10px] font-medium text-gray-500 mt-2 gap-2">
                                        <span class="bg-gray-100 px-2 py-0.5 rounded uppercase">{{ $event->type }}</span>
                                        <span>•</span>
                                        <span>{{ $event->start_time->format('H:i') }}</span>
                                    </div>
                                </a>
                            </div>
                            @empty
                            <div class="ml-6 text-sm text-gray-400 italic">Tidak ada agenda dekat ini.</div>
                            @endforelse
                        </div>
                        
                        <div class="mt-8">
                            <a href="{{ route('admin.events.index') }}" class="block w-full py-2 text-center text-xs font-bold text-[#83218F] border border-purple-100 rounded-xl hover:bg-purple-50 transition">
                                Kelola Semua Event
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-admin-layout>