<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-20">

        <div class="bg-[#83218F] pt-8 pb-8 px-4 sticky top-0 z-30 shadow-md rounded-b-[2rem]">
            <div class="flex items-center justify-between max-w-xl mx-auto mb-4">
                <a href="{{ route('dashboard') }}" class="p-2 bg-white/10 rounded-xl text-white hover:bg-white/20 transition backdrop-blur-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-white font-bold text-lg tracking-wide">Kabar IPNU</h1>
                <div class="w-10"></div>
            </div>

            <form action="{{ route('member.articles.index') }}" method="GET" class="max-w-xl mx-auto relative">
                <input type="text" name="search" placeholder="Cari berita..." value="{{ request('search') }}"
                       class="w-full bg-white/10 border border-white/20 rounded-xl py-3 pl-12 pr-4 text-white placeholder-purple-200 focus:bg-white/20 focus:outline-none focus:ring-0 backdrop-blur-sm transition">
                <svg class="w-5 h-5 text-purple-200 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </form>
        </div>

        <div class="px-4 -mt-1 relative z-20 max-w-xl mx-auto space-y-6">
            
            @if($articles->isEmpty())
                <div class="bg-white rounded-3xl p-8 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Belum ada artikel yang diterbitkan.</p>
                </div>
            @else

                @if($featured && !request('search'))
                <a href="{{ route('member.articles.show', $featured->slug) }}" class="block group relative rounded-3xl overflow-hidden shadow-lg h-64">
                    @if($featured->thumbnail)
                        <img src="{{ asset('storage/' . $featured->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 font-bold">IPNU</div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-6">
                        <span class="bg-[#83218F] text-white text-[10px] font-bold px-2 py-1 rounded w-fit mb-2">TERBARU</span>
                        <h2 class="text-white font-bold text-xl leading-tight line-clamp-2 mb-1">{{ $featured->title }}</h2>
                        <p class="text-gray-300 text-xs line-clamp-1">{{ \Carbon\Carbon::parse($featured->created_at)->diffForHumans() }}</p>
                    </div>
                </a>
                @endif

                <div>
                    <h3 class="font-bold text-gray-800 text-lg mb-4 px-1">Berita Lainnya</h3>
                    <div class="space-y-4">
                        @foreach(request('search') ? $articles : $others as $article)
                        <a href="{{ route('member.articles.show', $article->slug) }}" class="flex bg-white p-3 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition active:scale-95">
                            <div class="w-24 h-24 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0">
                                @if($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300 text-xs font-bold">IPNU</div>
                                @endif
                            </div>
                            
                            <div class="ml-4 flex flex-col justify-between py-1">
                                <div>
                                    <h4 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2">{{ $article->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit(strip_tags($article->content), 60) }}</p>
                                </div>
                                <div class="flex items-center text-[10px] text-gray-400 mt-2">
                                    <span class="bg-purple-50 text-[#83218F] px-1.5 py-0.5 rounded mr-2 font-bold">{{ $article->author->name }}</span>
                                    <span>{{ $article->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>