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

            <div class="pt-8 mt-8 border-t border-dashed border-gray-200">
                
                @if(isset($socials) && $socials->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3 mb-6">
                    @foreach($socials as $soc)
                        <a href="{{ $soc->url }}" target="_blank" class="group relative w-10 h-10 flex items-center justify-center rounded-full bg-white border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                            
                            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                {{ $soc->platform == 'instagram' ? 'bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500' : '' }}
                                {{ $soc->platform == 'tiktok' ? 'bg-black' : '' }}
                                {{ $soc->platform == 'youtube' ? 'bg-red-600' : '' }}
                                {{ $soc->platform == 'facebook' ? 'bg-blue-600' : '' }}
                                {{ $soc->platform == 'twitter' ? 'bg-black' : '' }}
                                {{ $soc->platform == 'website' ? 'bg-green-500' : '' }}
                            "></div>

                            <div class="relative z-10 text-gray-400 group-hover:text-white transition-colors duration-300">
                                @if($soc->platform == 'instagram')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2c2.717 0 3.056.01 4.122.06 1.065.05 1.79.217 2.428.465.66.254 1.216.598 1.772 1.153a4.908 4.908 0 011.153 1.772c.247.637.415 1.363.465 2.428.047 1.066.06 1.405.06 4.122 0 2.717-.01 3.056-.06 4.122-.05 1.065-.217 1.79-.465 2.428a4.883 4.883 0 01-1.153 1.772 4.915 4.915 0 01-1.772 1.153c-.637.247-1.363.415-2.428.465-1.066.047-1.405.06-4.122.06-2.717 0-3.056-.01-4.122-.06-1.065-.05-1.79-.217-2.428-.465a4.89 4.89 0 01-1.772-1.153 4.904 4.904 0 01-1.153-1.772c-.247-.637-.415-1.363-.465-2.428C2.013 15.056 2 14.717 2 12c0-2.717.01-3.056.06-4.122.05-1.065.217-1.79.465-2.428a4.88 4.88 0 011.153-1.772A4.897 4.897 0 015.468 2.525c.637-.247 1.363-.415 2.428-.465C8.944 2.013 9.283 2 12 2z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a5 5 0 100 10 5 5 0 000-10z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.5 6.5h.01"></path></svg>
                                @elseif($soc->platform == 'tiktok')
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.03 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.35-1.17 1.09-1.07 1.93.03.58.49 1.13 1.07 1.3.74.22 1.65.22 2.22-.45.62-.73.54-1.71.54-2.61V.02z"/></svg>
                                @elseif($soc->platform == 'youtube')
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                @elseif($soc->platform == 'facebook')
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                                @elseif($soc->platform == 'twitter')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif

                <div class="text-center">
                    <img src="{{ asset('logo/logopena.jpg') }}" class="w-8 h-8 mx-auto mb-2 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                    <p class="text-[10px] text-gray-400">
                        &copy; {{ date('Y') }} Pena Limbangan.<br/>
                        <span class="italic text-gray-300">Belajar, Berjuang, Bertakwa.</span>
                    </p>
                </div>
            </div>

        </div>
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