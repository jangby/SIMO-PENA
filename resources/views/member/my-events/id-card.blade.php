<!DOCTYPE html>
<html>
<head>
    <title>ID Card - {{ $registration->name }}</title>
    @vite(['resources/css/app.css'])
    <style>
        /* Agar saat diprint ukurannya pas */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen p-4">

    <div class="w-[320px] bg-white rounded-3xl shadow-2xl overflow-hidden relative border border-gray-200">
        
        <div class="h-32 bg-[#83218F] relative">
            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle, #ffffff 1px, transparent 1px); background-size: 10px 10px;"></div>
            <div class="absolute bottom-0 w-full flex justify-center -mb-10">
                <div class="w-20 h-20 bg-white rounded-full p-1 shadow-lg">
                    @if(Auth::user()->profile->photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile->photo) }}" class="w-full h-full rounded-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 rounded-full flex items-center justify-center text-gray-400 font-bold text-2xl">
                            {{ substr($registration->name, 0, 1) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="pt-12 pb-8 px-6 text-center">
            <h2 class="text-xl font-extrabold text-gray-800 leading-tight uppercase">{{ $registration->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">{{ $registration->school_origin }}</p>
            
            <div class="my-6 border-t border-b border-gray-100 py-4">
                <span class="block text-[10px] text-gray-400 uppercase tracking-widest mb-1">Kegiatan</span>
                <span class="block text-sm font-bold text-[#83218F]">{{ $registration->event->title }}</span>
                <span class="block text-xs text-gray-500 mt-1">{{ $registration->event->start_time->format('d M Y') }}</span>
            </div>

            <div class="flex justify-center">
                {!! $qrcode !!}
            </div>
            <p class="text-[10px] text-gray-400 mt-2">Scan QR ini untuk Absensi</p>
        </div>

        <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
            <p class="text-[10px] text-gray-400 font-bold tracking-wider">PAC IPNU LIMBANGAN</p>
        </div>
    </div>

    <div class="mt-8 flex gap-4 no-print">
        <a href="{{ route('my-events.show', $registration->id) }}" class="px-6 py-2 bg-gray-200 rounded-full text-gray-700 font-bold text-sm">Kembali</a>
        <button onclick="window.print()" class="px-6 py-2 bg-[#83218F] text-white rounded-full font-bold text-sm shadow-lg hover:bg-purple-800">Print / Simpan PDF</button>
    </div>

</body>
</html>