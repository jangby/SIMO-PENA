<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-white font-sans pb-10">
        
        <div class="relative h-72 w-full">
            @if($article->thumbnail)
                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-[#83218F] flex items-center justify-center text-white/20 font-bold text-4xl">IPNU</div>
            @endif
            
            <div class="absolute top-0 left-0 w-full p-4 pt-8 bg-gradient-to-b from-black/60 to-transparent flex justify-between items-center">
                <a href="{{ route('member.articles.index') }}" class="p-2 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/30 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                
                <button class="p-2 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/30 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                </button>
            </div>
        </div>

        <div class="max-w-xl mx-auto bg-white -mt-10 rounded-t-[2rem] relative z-10 px-6 pt-8">
            
            <div class="flex items-center gap-2 mb-4">
                <span class="bg-purple-100 text-[#83218F] text-[10px] font-bold px-2 py-1 rounded uppercase">Berita</span>
                <span class="text-gray-400 text-xs">•</span>
                <span class="text-gray-500 text-xs">{{ $article->created_at->format('d F Y') }}</span>
            </div>

            <h1 class="text-2xl font-extrabold text-gray-900 leading-snug mb-6">
                {{ $article->title }}
            </h1>

            <div class="flex items-center gap-3 mb-8 border-b border-gray-100 pb-6">
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold overflow-hidden">
                    {{ substr($article->author->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ $article->author->name }}</p>
                    <p class="text-xs text-gray-500">Penulis / Admin</p>
                </div>
            </div>

            <div class="prose prose-purple prose-sm max-w-none text-gray-600 leading-loose">
                {!! nl2br(e($article->content)) !!}
            </div>

            @if($related->isNotEmpty())
            <div class="mt-12 pt-8 border-t border-gray-100">
                <h3 class="font-bold text-gray-800 text-lg mb-4">Baca Juga</h3>
                <div class="space-y-4">
                    @foreach($related as $item)
                    <a href="{{ route('member.articles.show', $item->slug) }}" class="flex gap-4 items-center group">
                        <div class="w-20 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition">
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-800 leading-snug group-hover:text-[#83218F] transition line-clamp-2">
                                {{ $item->title }}
                            </h4>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>