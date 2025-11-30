<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - PAC IPNU</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased text-gray-900">

    <div class="relative h-[400px] w-full">
        @if($article->thumbnail)
            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-[#83218F] flex items-center justify-center text-white/20 font-bold text-4xl">IPNU</div>
        @endif
        
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-transparent to-black/80"></div>

        <div class="absolute top-0 left-0 w-full p-6 flex justify-between items-center z-20">
            <a href="{{ route('welcome') }}" class="flex items-center gap-2 text-white hover:text-purple-200 transition bg-black/20 backdrop-blur-md px-4 py-2 rounded-full border border-white/10">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span class="text-xs font-bold">Kembali ke Beranda</span>
            </a>
        </div>

        <div class="absolute bottom-0 left-0 w-full p-6 pb-12 max-w-4xl mx-auto z-10">
            <div class="max-w-3xl mx-auto">
                <span class="bg-[#83218F] text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-wide mb-3 inline-block shadow-lg">
                    Kabar IPNU
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold text-white leading-tight mb-4 shadow-black drop-shadow-md">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-4 text-gray-300 text-xs md:text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center text-[#83218F] font-bold">
                            {{ substr($article->author->name, 0, 1) }}
                        </div>
                        <span class="font-bold text-white">{{ $article->author->name }}</span>
                    </div>
                    <span>&bull;</span>
                    <span>{{ $article->created_at->format('d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-6 py-12 -mt-6 bg-white relative rounded-t-[2rem] z-20">
        <article class="prose prose-lg prose-purple max-w-none text-gray-700 leading-loose">
            {!! nl2br(e($article->content)) !!}
        </article>

        <div class="mt-12 pt-8 border-t border-gray-100 flex justify-between items-center">
            <span class="text-gray-400 text-sm italic">Bagikan kabar baik ini:</span>
            <div class="flex gap-2">
                <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-[#83218F] hover:text-white transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                </button>
                <button class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-green-600 hover:text-white transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                </button>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-8 text-center border-t border-gray-200">
        <p class="text-xs text-gray-400">&copy; {{ date('Y') }} PAC IPNU Limbangan.</p>
    </div>

</body>
</html>