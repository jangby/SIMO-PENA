<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Dokumentasi - Pena</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900" x-data="{ 
    imgModal : false, 
    imgSrc : '', 
    imgId : '', 
    imgTitle : '', 
    imgDate : '' 
}">

    <div class="bg-[#83218F] pt-6 pb-6 px-4 shadow-md sticky top-0 z-30">
        <div class="max-w-3xl mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="p-2 bg-white/20 rounded-full text-white hover:bg-white/30 transition backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-white font-bold text-lg tracking-wide">Galeri Kegiatan</h1>
            <div class="w-9"></div> </div>
    </div>

    <div class="max-w-4xl mx-auto px-2 py-4 pb-20">
        
        @if($galleries->isEmpty())
            <div class="flex flex-col items-center justify-center h-[60vh] text-gray-400">
                <div class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-10 h-10 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <p class="text-sm font-medium">Belum ada dokumentasi.</p>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-1.5">
                @foreach($galleries as $gallery)
                <div class="relative group cursor-pointer overflow-hidden aspect-square bg-gray-200 rounded-lg"
                     @click="
                        imgModal = true; 
                        imgSrc = '{{ asset('storage/' . $gallery->image) }}'; 
                        imgId = '{{ $gallery->id }}'; 
                        imgTitle = '{{ $gallery->title }}'; 
                        imgDate = '{{ $gallery->created_at->format('d M Y') }}'
                     ">
                    
                    <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" loading="lazy">
                    
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>
                @endforeach
            </div>

            <div class="mt-8 px-2">
                {{ $galleries->links() }}
            </div>
        @endif

    </div>

    <div x-show="imgModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black/95 backdrop-blur-sm p-4"
         style="display: none;">

        <button @click="imgModal = false" class="absolute top-4 right-4 p-2 bg-white/10 rounded-full text-white hover:bg-white/30 transition z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="relative w-full max-w-4xl max-h-screen flex flex-col items-center justify-center" @click.outside="imgModal = false">
            
            <img :src="imgSrc" class="max-w-full max-h-[75vh] rounded-lg shadow-2xl object-contain">
            
            <div class="mt-6 flex flex-col items-center text-center w-full px-4">
                <h3 class="text-white font-bold text-lg leading-tight" x-text="imgTitle"></h3>
                <p class="text-gray-400 text-xs mb-5 mt-1" x-text="imgDate"></p>
                
                <a :href="'/dokumentasi/download/' + imgId" class="flex items-center gap-2 bg-[#83218F] hover:bg-purple-700 text-white px-8 py-3 rounded-full font-bold text-sm shadow-lg shadow-purple-900/50 transition transform active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Unduh Kualitas HD
                </a>
            </div>
        </div>
    </div>

</body>
</html>