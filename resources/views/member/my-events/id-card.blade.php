<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ID Card Peserta - {{ $registration->name }}</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=archivo:400,600,700,800&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Archivo', sans-serif;
            background-color: #f3f4f6; /* bg-gray-100 */
        }
        /* Pattern Halus untuk Background Header */
        .pattern-grid {
            background-image: linear-gradient(to right, rgba(255,255,255,0.05) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255,255,255,0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        /* Agar background & warna tercetak sempurna */
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; background: white; }
            .no-print { display: none !important; }
            .print-shadow-none { shadow: none !important; filter: none !important; }
            .id-card-container { margin: 0 auto; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-6">

    <div class="id-card-container w-[340px] bg-white rounded-[1.5rem] overflow-hidden shadow-2xl relative print-shadow-none">
        
        <div class="relative bg-gradient-to-br from-[#83218F] to-purple-900 pt-8 pb-16 px-6 text-center overflow-hidden">
            <div class="pattern-grid absolute inset-0 opacity-30"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <img src="{{ asset('logo/LAKMUD.png') }}" class="h-12 w-auto mb-3 drop-shadow-md bg-white/10 p-1 rounded-full backdrop-blur-sm">
                
                <span class="inline-block bg-yellow-400 text-[#83218F] text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full mb-2 shadow-sm">
                    {{ $registration->event->type }}
                </span>

                <h1 class="text-white font-extrabold text-xl leading-tight uppercase tracking-tight drop-shadow-sm">
                    {{ $registration->event->title }}
                </h1>
                <p class="text-purple-200 text-xs mt-2 font-medium flex items-center justify-center gap-2">
                   <span>📅 {{ $registration->event->start_time->format('d M Y') }}</span>
                </p>
            </div>
        </div>

        <div class="relative z-20 flex justify-center -mt-12">
            <div class="w-28 h-28 rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-gray-200">
                @if(Auth::user()->profile && Auth::user()->profile->photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-purple-100 text-[#83218F] text-3xl font-extrabold">
                        {{ substr($registration->name, 0, 1) }}
                    </div>
                @endif
            </div>
        </div>

        <div class="pt-4 pb-6 px-6 text-center">
            <h2 class="text-gray-900 font-black text-xl uppercase leading-none mb-1">
                {{ $registration->name }}
            </h2>
            <span class="block text-[#83218F] text-sm font-bold tracking-widest uppercase mb-4">Peserta Resmi</span>

            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 text-sm space-y-3 mb-6 text-left">
                <div class="flex items-start gap-3">
                   <div class="w-6 flex-shrink-0 text-center text-gray-400">🏫</div>
                   <div>
                       <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Delegasi / Sekolah</p>
                       <p class="font-bold text-gray-800">{{ $registration->school_origin }}</p>
                   </div>
                </div>
                <div class="flex items-start gap-3 border-t border-gray-100 pt-3">
                   <div class="w-6 flex-shrink-0 text-center text-gray-400">📍</div>
                   <div>
                       <p class="text-xs text-gray-500 font-bold uppercase tracking-wider">Asal / Domisili</p>
                       <p class="font-bold text-gray-800 line-clamp-1">{{ $registration->address }}</p>
                   </div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-2xl border-2 border-dashed border-purple-200 inline-block shadow-sm">
                <div class="flex justify-center">
                     {!! QrCode::size(130)->color(131, 33, 143)->margin(1)->generate($registration->id) !!}
                </div>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mt-2">Scan untuk Absensi</p>
            </div>

        </div>

        <div class="bg-[#83218F] p-3 text-center relative overflow-hidden flex items-center justify-center gap-2">
             <img src="{{ asset('logo/logo.png') }}" class="h-5 w-auto brightness-0 invert opacity-50">
             <p class="text-white/60 text-[10px] font-bold tracking-[0.2em] uppercase">
                PAC IPNU Limbangan • Sah
             </p>
        </div>

    </div>
    <div class="mt-8 flex flex-col md:flex-row gap-4 no-print">
        <a href="{{ route('member.attendance.show', $registration->id) }}" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-full font-bold text-sm hover:bg-gray-50 transition flex items-center justify-center gap-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <button onclick="window.print()" class="px-8 py-3 bg-[#83218F] text-white rounded-full font-bold text-sm shadow-lg hover:bg-purple-800 transition flex items-center justify-center gap-2 transform active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / Simpan PDF
        </button>
    </div>

</body>
</html>