<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>PAC IPNU Limbangan - Portal Resmi</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .mesh-bg {
            background-color: #83218F;
            background-image: 
                radial-gradient(at 0% 0%, hsla(280,100%,70%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(320,100%,60%,1) 0, transparent 50%);
        }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
    </style>
</head>
<body class="antialiased text-slate-800 flex flex-col min-h-screen">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-gray-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/logopena.jpg') }}" class="h-9 w-9 object-contain drop-shadow-sm">
                    <div class="leading-tight">
                        <h1 class="font-bold text-[#83218F] text-base md:text-lg tracking-tight">Pena</h1>
                        <p class="text-gray-400 text-[10px] md:text-xs font-medium tracking-widest uppercase">Limbangan</p>
                    </div>
                </div>

                <div class="hidden md:flex gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-[#83218F] transition">Fitur</a>
                    <a href="#gallery" class="text-sm font-medium text-gray-600 hover:text-[#83218F] transition">Galeri</a>
                    <a href="#event-list" class="text-sm font-medium text-gray-600 hover:text-[#83218F] transition">Kegiatan</a>
                </div>

                <div class="flex items-center gap-2 md:gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-[#83218F] text-white px-5 py-2 rounded-full font-bold text-xs md:text-sm shadow-lg shadow-purple-200 transition transform hover:-translate-y-0.5">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-500 font-bold text-xs md:text-sm px-2 md:px-3 hover:text-[#83218F] transition">
                                Masuk
                            </a>
                            
                            <a href="{{ route('register') }}" class="bg-[#83218F] text-white px-4 md:px-5 py-2 rounded-full font-bold text-xs md:text-sm shadow-lg shadow-purple-200 transition transform hover:-translate-y-0.5 hover:bg-purple-800">
                                Daftar
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-28 pb-20 md:pt-40 md:pb-32 mesh-bg rounded-b-[2.5rem] md:rounded-b-[4rem] overflow-hidden shadow-2xl z-10">
        
        <div class="absolute top-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 md:w-96 md:h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-10 md:gap-12 items-center">
                
                <div class="text-center lg:text-left z-20 w-full lg:w-1/2">
                    <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-white/20 border border-white/30 text-white text-[10px] md:text-xs font-bold uppercase tracking-wider mb-6 backdrop-blur-md shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                        Portal Resmi Organisasi
                    </span>
                    
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold text-white mb-6 leading-tight tracking-tight drop-shadow-sm">
                        Belajar, Berjuang, <br/>
                        <span class="text-yellow-300 relative inline-block">
                            Bertakwa.
                        </span>
                    </h1>
                    
                    <p class="text-purple-100 text-sm md:text-lg max-w-lg mx-auto lg:mx-0 mb-8 leading-relaxed font-medium opacity-90">
                        Platform digital terintegrasi untuk pendaftaran kaderisasi, manajemen anggota, dan informasi kegiatan PAC IPNU Limbangan.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 mb-8 lg:mb-0">
                        <a href="#event-list" class="bg-white text-[#83218F] px-8 py-3.5 rounded-full font-bold text-sm shadow-xl hover:shadow-2xl hover:bg-gray-50 transition transform hover:-translate-y-1 border-2 border-transparent">
                            Lihat Kegiatan
                        </a>
                        <a href="{{ route('public.structure') }}" class="bg-transparent border-2 border-white/30 text-white px-8 py-3.5 rounded-full font-bold text-sm hover:bg-white/10 transition flex items-center justify-center gap-2 backdrop-blur-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Struktur
                        </a>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 flex justify-center lg:justify-end z-20">
                    <div class="w-full max-w-md">
                        <div class="grid grid-cols-2 gap-3 md:gap-4">
                            
                            <div class="bg-white p-5 rounded-[2rem] shadow-lg flex flex-col justify-between h-36 md:h-40 relative overflow-hidden group hover:-translate-y-1 transition duration-300">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-[#83218F] mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-[#83218F] font-black text-2xl md:text-3xl">{{ \App\Models\User::where('role', 'member')->count() }}</h3>
                                    <p class="text-gray-400 text-[10px] uppercase font-bold tracking-widest mt-1">Total Anggota</p>
                                </div>
                            </div>

                            <div class="bg-yellow-400 p-5 rounded-[2rem] shadow-lg flex flex-col justify-between h-36 md:h-40 relative overflow-hidden group hover:-translate-y-1 transition duration-300">
                                <div class="w-10 h-10 bg-white/30 rounded-xl flex items-center justify-center text-white mb-2 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-[#83218F] font-black text-2xl md:text-3xl">{{ \App\Models\Event::count() }}</h3>
                                    <p class="text-[#83218F]/80 text-[10px] uppercase font-bold tracking-widest mt-1">Total Kegiatan</p>
                                </div>
                            </div>

                            <div class="col-span-2 bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-[2rem] shadow-xl flex items-center justify-between h-24 mt-1 hover:-translate-y-1 transition duration-300">
                                <div>
                                    <h3 class="text-white font-black text-2xl md:text-3xl">{{ \App\Models\Article::where('status', 'published')->count() }}</h3>
                                    <p class="text-purple-100 text-[10px] uppercase font-bold tracking-widest mt-1">Berita & Artikel</p>
                                </div>
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="bg-gray-50 -mt-10 md:-mt-20 relative z-20 rounded-t-[2.5rem] md:rounded-t-[4rem] overflow-hidden min-h-screen">
        
        <div id="features" class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-20">
            <div class="text-center mb-8 md:mb-10">
                <span class="text-[#83218F] font-bold tracking-widest text-[10px] md:text-xs uppercase bg-purple-50 px-3 py-1 rounded-full">Fitur Unggulan</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-3">Layanan Digital IPNU</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-8">
                <div class="bg-white p-5 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-[#83218F] mb-3 group-hover:bg-[#83218F] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="font-bold text-sm md:text-lg text-gray-800 mb-1">Absensi QR</h3>
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Presensi digital cepat.</p>
                </div>

                <div class="bg-white p-5 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                    <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center text-yellow-600 mb-3 group-hover:bg-yellow-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-sm md:text-lg text-gray-800 mb-1">Database</h3>
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Data anggota terpusat.</p>
                </div>

                <div class="bg-white p-5 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-sm md:text-lg text-gray-800 mb-1">E-Event</h3>
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Daftar kegiatan online.</p>
                </div>

                <div class="bg-white p-5 rounded-2xl md:rounded-3xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 group">
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-3 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    </div>
                    <h3 class="font-bold text-sm md:text-lg text-gray-800 mb-1">Berita</h3>
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Info terkini pelajar NU.</p>
                </div>
            </div>
        </div>

        @if($galleries->isNotEmpty())
        <div id="gallery" class="py-8 md:py-12 bg-white border-y border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center mb-6 px-2">
                    <div>
                        <h2 class="text-xl md:text-3xl font-extrabold text-gray-900">Galeri</h2>
                        <p class="text-gray-400 text-xs hidden md:block">Dokumentasi kegiatan kami</p>
                    </div>
                    <a href="{{ route('public.gallery') }}" class="text-xs md:text-sm font-bold text-[#83218F] bg-purple-50 px-3 py-1.5 rounded-full hover:bg-purple-100 transition">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="swiper mySwiper rounded-2xl md:rounded-3xl shadow-lg overflow-hidden aspect-[16/9] md:aspect-[21/9]">
                    <div class="swiper-wrapper">
                        @foreach($galleries as $gallery)
                        <div class="swiper-slide relative group">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent flex flex-col justify-end p-6 md:p-10">
                                <h3 class="text-white font-bold text-base md:text-2xl line-clamp-1 mb-1">{{ $gallery->title }}</h3>
                                <p class="text-gray-300 text-[10px] md:text-xs">{{ $gallery->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
        @endif

        <div id="event-list" class="max-w-7xl mx-auto px-4 sm:px-6 py-12 md:py-20">
            <div class="text-center mb-8 md:mb-10">
                <span class="text-yellow-600 font-bold tracking-widest text-[10px] md:text-xs uppercase bg-yellow-50 px-3 py-1 rounded-full">Open Recruitment</span>
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mt-3">Pendaftaran Buka</h2>
            </div>

            @if($events->isEmpty())
                <div class="bg-white rounded-3xl p-8 md:p-10 text-center border-2 border-dashed border-gray-200">
                    <p class="text-gray-400 text-sm font-medium">Belum ada kegiatan yang dibuka.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 md:gap-6">
                    @foreach($events as $event)
                    <a href="{{ route('event.register', $event->id) }}" class="group block bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 flex flex-col h-full">
                        <div class="h-40 md:h-48 bg-gray-200 relative overflow-hidden">
                            @if($event->banner)
                                <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-[#83218F] flex items-center justify-center text-white/20 font-black text-2xl md:text-3xl">IPNU</div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 text-[#83218F] text-[10px] font-bold px-2 py-1 rounded-md uppercase shadow-sm">
                                    {{ $event->type }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5 flex-1 flex flex-col">
                            <div class="flex items-center text-[10px] md:text-xs text-gray-500 mb-2 gap-3">
                                <span class="flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $event->start_time->format('d M') }}
                                </span>
                                <span class="flex items-center truncate">
                                    <svg class="w-3.5 h-3.5 mr-1 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ Str::limit($event->location, 15) }}
                                </span>
                            </div>

                            <h3 class="text-base md:text-xl font-bold text-gray-900 mb-3 leading-snug group-hover:text-[#83218F] transition line-clamp-2">
                                {{ $event->title }}
                            </h3>
                            
                            <div class="mt-auto pt-3 border-t border-gray-50 flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-400 group-hover:text-[#83218F] transition">Daftar</span>
                                <div class="w-7 h-7 md:w-8 md:h-8 rounded-full bg-gray-50 flex items-center justify-center group-hover:bg-[#83218F] group-hover:text-white transition">
                                    <svg class="w-3 h-3 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>

        @if($articles->isNotEmpty())
        <div id="news-section" class="py-12 md:py-16 bg-white border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between items-center mb-6 md:mb-8">
                    <h2 class="text-xl md:text-2xl font-extrabold text-gray-900">Kabar IPNU</h2>
                    <a href="{{ route('public.article.show', $articles->first()->slug) }}" class="text-xs md:text-sm font-bold text-gray-500 hover:text-[#83218F]">Arsip Berita &rarr;</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                    @foreach($articles as $article)
                    <a href="{{ route('public.article.show', $article->slug) }}" class="group block">
                        <div class="relative h-40 md:h-48 rounded-2xl overflow-hidden mb-3 md:mb-4 bg-gray-200">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold">IPNU NEWS</div>
                            @endif
                            <div class="absolute bottom-2 left-2 md:bottom-3 md:left-3 bg-white/90 backdrop-blur-sm px-2 py-0.5 md:px-3 md:py-1 rounded-lg text-[10px] font-bold text-[#83218F] shadow-sm">
                                {{ $article->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <h3 class="font-bold text-base md:text-lg text-gray-900 leading-snug group-hover:text-[#83218F] transition line-clamp-2">
                            {{ $article->title }}
                        </h3>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        <div class="bg-gray-50 py-10 md:py-12 text-center border-t border-gray-200">
            @if(isset($socials) && $socials->isNotEmpty())
            <div class="flex justify-center gap-3 md:gap-4 mb-6 md:mb-8">
                @foreach($socials as $soc)
                    <a href="{{ $soc->url }}" target="_blank" class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center bg-white shadow-sm border border-gray-100 hover:-translate-y-1 transition text-gray-400 hover:text-white
                        {{ $soc->platform == 'instagram' ? 'hover:bg-gradient-to-tr hover:from-yellow-400 hover:via-red-500 hover:to-purple-500' : '' }}
                        {{ $soc->platform == 'tiktok' ? 'hover:bg-black' : '' }}
                        {{ $soc->platform == 'youtube' ? 'hover:bg-red-600' : '' }}
                        {{ $soc->platform == 'facebook' ? 'hover:bg-blue-600' : '' }}
                        {{ $soc->platform == 'twitter' ? 'hover:bg-black' : '' }}
                        {{ $soc->platform == 'website' ? 'hover:bg-green-600' : '' }}
                    ">
                        @if($soc->platform == 'instagram') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.247-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.468 2.525c.637-.247 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a5 5 0 100 10 5 5 0 000-10z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 6.5h.01"></path></svg>
                        @else <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                        @endif
                    </a>
                @endforeach
            </div>
            @endif

            <img src="{{ asset('logo/logopena.jpg') }}" class="w-10 h-10 mx-auto mb-3 opacity-50 grayscale hover:grayscale-0 transition duration-500">
            <p class="text-xs text-gray-400">
                &copy; {{ date('Y') }} Pena Limbangan.<br/>
                <span class="italic text-gray-300">Belajar, Berjuang, Bertakwa.</span>
            </p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 20,
            centeredSlides: false,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    </script>
</body>
</html>