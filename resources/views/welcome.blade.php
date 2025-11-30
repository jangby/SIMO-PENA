<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <title>PAC IPNU Limbangan - Super App</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Custom Gradient Text */
        .text-gradient {
            background: linear-gradient(135deg, #FFFFFF 0%, #E9D5FF 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        /* Mesh Gradient Background */
        .mesh-bg {
            background-color: #83218F;
            background-image: 
                radial-gradient(at 0% 0%, hsla(280,100%,70%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(320,100%,60%,1) 0, transparent 50%);
        }

        /* Glass Card */
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="antialiased text-slate-800">

    <div class="fixed top-0 left-0 w-full h-96 mesh-bg rounded-b-[3rem] shadow-2xl z-0"></div>

    <div class="relative z-10 max-w-md mx-auto min-h-screen flex flex-col">
        
        <header class="px-6 pt-12 pb-6 flex justify-between items-start">
            <div>
                <div class="flex items-center gap-2 mb-1 opacity-90">
                    <span class="bg-white/20 p-1 rounded-full"><img src="{{ asset('logo/logopena.jpg') }}" class="w-4 h-4"></span>
                    <span class="text-white text-[10px] font-bold tracking-widest uppercase">PENA Kec. Bl. Limbangan</span>
                </div>
                <h1 class="text-3xl font-extrabold text-white leading-tight">
                    Portal <br/> <span class="text-yellow-300">Kaderisasi.</span>
                </h1>
            </div>
            
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="flex items-center gap-2 bg-white text-[#83218F] px-4 py-2 rounded-full font-bold text-xs shadow-lg active:scale-95 transition">
                        <div class="w-5 h-5 rounded-full bg-purple-100 flex items-center justify-center text-[10px]">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        Akun
                    </a>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-5 py-2.5 rounded-full font-bold text-xs hover:bg-white hover:text-[#83218F] transition">
                        Masuk Akun
                    </a>
                @endauth
            </div>
        </header>

        <div class="px-6 mb-6">
            <div class="bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl p-3 flex items-center gap-3 text-purple-100 shadow-inner">
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span class="text-sm font-medium opacity-80">Cari kegiatan atau berita...</span>
            </div>
        </div>

        <div class="px-6 grid grid-cols-4 gap-4 mb-8">
            <a href="{{ route('public.structure') }}" class="flex flex-col items-center gap-2 group">
                <div class="w-14 h-14 bg-white rounded-2xl shadow-lg shadow-purple-900/20 flex items-center justify-center text-[#83218F] group-active:scale-90 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white/90">Struktur</span>
            </a>
            <a href="{{ route('public.gallery') }}" class="flex flex-col items-center gap-2 group">
                <div class="w-14 h-14 bg-white rounded-2xl shadow-lg shadow-purple-900/20 flex items-center justify-center text-yellow-500 group-active:scale-90 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white/90">Galeri</span>
            </a>
            <a href="#news-section" class="flex flex-col items-center gap-2 group">
                <div class="w-14 h-14 bg-white rounded-2xl shadow-lg shadow-purple-900/20 flex items-center justify-center text-blue-500 group-active:scale-90 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white/90">Berita</span>
            </a>
            <a href="{{ route('register') }}" class="flex flex-col items-center gap-2 group">
                <div class="w-14 h-14 bg-gradient-to-br from-yellow-300 to-yellow-500 rounded-2xl shadow-lg shadow-yellow-500/30 flex items-center justify-center text-[#83218F] group-active:scale-90 transition border-2 border-white/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-white/90">Daftar</span>
            </a>
        </div>

        <div class="glass rounded-t-[2.5rem] flex-1 px-6 pt-8 pb-20 shadow-[0_-10px_40px_rgba(0,0,0,0.1)]">
            
            @if($galleries->isNotEmpty())
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Highlight</h2>
                    <a href="{{ route('public.gallery') }}" class="text-xs font-bold text-[#83218F]">Lihat Semua</a>
                </div>
                
                <div class="swiper mySwiper rounded-2xl shadow-xl overflow-hidden aspect-video">
                    <div class="swiper-wrapper">
                        @foreach($galleries as $gallery)
                        <div class="swiper-slide relative">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="bg-[#83218F] text-white text-[9px] font-bold px-2 py-1 rounded mb-1 inline-block">Galeri</span>
                                <h3 class="text-white font-bold text-sm truncate">{{ $gallery->title }}</h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            @endif

            <div id="event-list" class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Pendaftaran Buka</h2>
                
                @if($events->isEmpty())
                    <div class="bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-6 text-center">
                        <p class="text-xs text-gray-400">Tidak ada kegiatan aktif saat ini.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($events as $event)
                        <a href="{{ route('event.register', $event->id) }}" class="block bg-white p-1 rounded-2xl shadow-sm border border-gray-100 active:scale-95 transition">
                            <div class="flex items-center gap-4 p-2">
                                <div class="w-16 h-16 bg-purple-50 rounded-xl flex flex-col items-center justify-center text-[#83218F] shrink-0">
                                    <span class="text-[10px] font-bold uppercase">{{ $event->start_time->format('M') }}</span>
                                    <span class="text-xl font-black">{{ $event->start_time->format('d') }}</span>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="bg-yellow-100 text-yellow-700 text-[9px] font-bold px-1.5 py-0.5 rounded uppercase">{{ $event->type }}</span>
                                        <span class="text-[10px] text-gray-400 truncate flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ Str::limit($event->location, 15) }}
                                        </span>
                                    </div>
                                    <h3 class="font-bold text-gray-800 text-sm truncate">{{ $event->title }}</h3>
                                    <p class="text-[10px] text-[#83218F] font-semibold mt-1">Ketuk untuk daftar &rarr;</p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>

            @if($articles->isNotEmpty())
            <div id="news-section" class="mb-8">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Kabar IPNU</h2>
                
                <div class="flex overflow-x-auto gap-4 pb-4 -mx-6 px-6 no-scrollbar">
                    @foreach($articles as $article)
                    <a href="{{ route('public.article.show', $article->slug) }}" class="shrink-0 w-60 group">
                        <div class="relative h-32 rounded-xl overflow-hidden mb-3">
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs font-bold">NO IMG</div>
                            @endif
                            <div class="absolute top-2 left-2 bg-white/90 px-2 py-0.5 rounded text-[9px] font-bold text-[#83218F]">
                                {{ $article->created_at->diffForHumans() }}
                            </div>
                        </div>
                        <h4 class="font-bold text-sm text-gray-800 leading-snug line-clamp-2 group-hover:text-[#83218F] transition">
                            {{ $article->title }}
                        </h4>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="text-center pt-8 border-t border-dashed border-gray-200">
                <img src="{{ asset('logo/logopena.jpg') }}" class="w-8 h-8 mx-auto mb-2 opacity-50 grayscale">
                <p class="text-[10px] text-gray-400">
                    &copy; {{ date('Y') }} PAC IPNU Limbangan.<br/>
                    <span class="italic">Belajar, Berjuang, Bertakwa.</span>
                </p>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 10,
            centeredSlides: true,
            loop: true,
            autoplay: { delay: 3000, disableOnInteraction: false },
            pagination: { el: ".swiper-pagination", clickable: true },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });
    </script>
</body>
</html>