<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struktur Organisasi - PAC IPNU</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="relative bg-[#83218F] pt-8 pb-32 px-4 shadow-xl rounded-b-[3rem] overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto flex items-center justify-between mb-4">
            <a href="{{ route('welcome') }}" class="p-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white hover:bg-white/20 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div class="text-center">
                <h1 class="text-white font-extrabold text-xl tracking-wide uppercase">Struktur Organisasi</h1>
                <p class="text-purple-200 text-xs font-medium tracking-widest mt-1">Masa Khidmat 2024-2026</p>
            </div>
            <div class="w-10"></div> </div>
    </div>

    <div class="max-w-6xl mx-auto px-6 -mt-20 relative z-20 pb-20">
        
        @php 
            $ketua = $structures->where('level', 1)->first(); 
            $others = $structures->where('level', '>', 1);
        @endphp

        @if($ketua)
        <div class="flex justify-center mb-12">
            <div class="relative bg-white p-6 rounded-[2.5rem] shadow-2xl border-4 border-white text-center w-full max-w-xs transform hover:-translate-y-2 transition duration-500 group">
                
                <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-yellow-400 text-[#83218F] p-2 rounded-full shadow-lg border-4 border-[#83218F]">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>

                <div class="w-32 h-32 mx-auto rounded-full p-1 bg-gradient-to-tr from-yellow-400 to-[#83218F] mb-4 shadow-inner">
                    <div class="w-full h-full rounded-full overflow-hidden border-4 border-white bg-gray-100">
                        @if($ketua->photo)
                            <img src="{{ asset('storage/' . $ketua->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold text-3xl">{{ substr($ketua->name, 0, 1) }}</div>
                        @endif
                    </div>
                </div>

                <h2 class="text-xl font-black text-gray-800 leading-tight mb-1">{{ $ketua->name }}</h2>
                <p class="text-[#83218F] font-bold text-sm uppercase tracking-wider mb-3">{{ $ketua->position }}</p>
                
                @if($ketua->instagram_link)
                    <a href="{{ $ketua->instagram_link }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-100 text-pink-600 hover:bg-pink-50 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
            </div>
        </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @foreach($others as $s)
            <div class="group bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition duration-300 text-center relative overflow-hidden">
                
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-transparent via-[#83218F] to-transparent opacity-0 group-hover:opacity-100 transition"></div>

                <div class="w-16 h-16 mx-auto rounded-full p-0.5 bg-gray-200 mb-3 group-hover:bg-[#83218F] transition">
                    <div class="w-full h-full rounded-full overflow-hidden bg-white">
                        @if($s->photo)
                            <img src="{{ asset('storage/' . $s->photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 font-bold">{{ substr($s->name, 0, 1) }}</div>
                        @endif
                    </div>
                </div>

                <h3 class="font-bold text-gray-800 text-sm leading-tight mb-1 group-hover:text-[#83218F] transition">{{ $s->name }}</h3>
                <p class="text-xs text-gray-500 font-medium mb-2">{{ $s->position }}</p>
                
                @if($s->department)
                    <span class="inline-block bg-purple-50 text-[#83218F] text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                        {{ $s->department }}
                    </span>
                @else
                    <span class="inline-block bg-gray-100 text-gray-500 text-[9px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                        BPH Inti
                    </span>
                @endif

                @if($s->instagram_link)
                    <div class="mt-3 pt-3 border-t border-gray-50">
                        <a href="{{ $s->instagram_link }}" target="_blank" class="text-gray-400 hover:text-pink-600 transition flex justify-center">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                    </div>
                @endif
            </div>
            @endforeach
        </div>

    </div>

    <div class="text-center py-8 text-xs text-gray-400 border-t border-gray-200">
        &copy; {{ date('Y') }} PAC IPNU Limbangan
    </div>

</body>
</html>