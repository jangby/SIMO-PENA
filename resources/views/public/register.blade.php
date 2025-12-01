<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar: {{ $event->title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="bg-[#83218F] pt-6 pb-32 px-4 relative rounded-b-[3rem] shadow-lg">
        <div class="max-w-xl mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="p-2 bg-white/20 rounded-full text-white hover:bg-white/30 transition backdrop-blur-sm border border-white/10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            
            <h1 class="text-white font-bold text-lg tracking-wide">Formulir Pendaftaran</h1>
            
            <div class="w-10"></div>
        </div>

        <div class="max-w-xl mx-auto mt-6 text-center text-white px-4">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest mb-2 border border-white/10">
                {{ $event->type }}
            </span>
            <h2 class="text-2xl font-extrabold leading-tight mb-2">{{ $event->title }}</h2>
            
            <div class="mt-4 mb-4">
                @if($event->price > 0)
                    <div class="inline-flex flex-col items-center bg-white/10 backdrop-blur-md rounded-xl p-3 border border-yellow-400/50 shadow-lg">
                        <span class="text-[10px] text-yellow-200 uppercase tracking-widest font-bold">Biaya Pendaftaran</span>
                        <span class="text-2xl font-black text-yellow-400">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <span class="inline-block px-4 py-2 bg-green-500/20 text-green-300 font-bold rounded-lg border border-green-400/30">
                        GRATIS (FREE)
                    </span>
                @endif
            </div>

            <div class="flex justify-center items-center gap-4 text-purple-200 text-xs">
                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $event->start_time->format('d M Y') }}</span>
                <span class="flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ Str::limit($event->location, 15) }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-xl mx-auto px-4 -mt-20 relative z-10 pb-10">
        
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <form method="POST" action="{{ route('event.store', $event->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="p-6 space-y-5">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" placeholder="Sesuai KTP/Identitas" required>
                        @error('name') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center" placeholder="Kota" required>
                            @error('birth_place') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center" required>
                            @error('birth_date') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Nomor WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="number" name="phone" value="{{ old('phone') }}" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" placeholder="08xxxxxxxxxx" required>
                        </div>
                        @error('phone') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Asal Sekolah / Komisariat</label>
                        <input type="text" name="school_origin" value="{{ old('school_origin') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" placeholder="Nama Sekolah / Institusi" required>
                        @error('school_origin') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Alamat Domisili</label>
                        <textarea name="address" rows="3" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition p-3 text-sm placeholder-gray-400" placeholder="Dusun, RT/RW, Desa, Kecamatan..." required>{{ old('address') }}</textarea>
                        @error('address') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t border-gray-100 my-4"></div>

                    @if($event->price > 0)
                    <div class="bg-purple-50 rounded-2xl p-4 border border-purple-100">
                        <label class="block text-xs font-bold text-[#83218F] uppercase tracking-wide mb-2">
                            Transfer Pembayaran (Rp {{ number_format($event->price, 0, ',', '.') }})
                        </label>
                        
                        <div class="space-y-2 mb-4">
                            @if(!empty($event->bank_accounts))
                                @foreach($event->bank_accounts as $bank)
                                <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-purple-100 shadow-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-100 text-[#83218F] rounded-lg flex items-center justify-center font-bold text-xs uppercase">
                                            {{ substr($bank['bank'], 0, 4) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-700 uppercase">{{ $bank['bank'] }}</p>
                                            <p class="text-sm font-black text-gray-900 tracking-wide">{{ $bank['number'] }}</p>
                                            <p class="text-[10px] text-gray-500">a.n {{ $bank['name'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $bank['number'] }}'); alert('No Rekening Disalin!')" class="text-gray-400 hover:text-[#83218F]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <p class="text-xs text-red-500 italic">Belum ada info rekening. Hubungi panitia.</p>
                            @endif
                        </div>

                        <div class="relative">
                            <input type="file" name="payment_proof" id="payment_proof" class="hidden" accept="image/*" onchange="showFileName('payment_proof', 'payment-label')" required>
                            <label for="payment_proof" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-[#83218F]/30 rounded-xl cursor-pointer hover:bg-white transition" id="payment-label">
                                <svg class="w-8 h-8 text-[#83218F]/50 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span class="text-xs text-gray-500 font-medium">Upload Bukti Transfer</span>
                            </label>
                        </div>
                        @error('payment_proof') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>
                    @endif

                    @if($event->type == 'lakmud')
                    <div class="bg-yellow-50 rounded-2xl p-4 border border-yellow-200">
                        <label class="block text-xs font-bold text-yellow-700 uppercase tracking-wide mb-2">Sertifikat Makesta</label>
                        
                        <div class="relative">
                            <input type="file" name="certificate_file" id="certificate_file" class="hidden" accept="image/*,application/pdf" onchange="showFileName('certificate_file', 'cert-label')">
                            <label for="certificate_file" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-yellow-400/50 rounded-xl cursor-pointer hover:bg-white transition" id="cert-label">
                                <svg class="w-8 h-8 text-yellow-500/50 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="text-xs text-gray-500 font-medium">Upload Sertifikat</span>
                            </label>
                        </div>
                        @error('certificate_file') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>
                    @endif

                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <button type="submit" class="w-full bg-[#83218F] text-white py-4 rounded-xl font-bold shadow-lg shadow-purple-200 hover:bg-purple-800 transition transform active:scale-95 flex justify-center items-center uppercase tracking-wide text-sm">
                        Kirim Pendaftaran
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>
                    <p class="text-[10px] text-gray-400 text-center mt-3">Data Anda aman dan hanya digunakan untuk keperluan organisasi.</p>
                </div>

            </form>
        </div>
    </div>

    <script>
        function showFileName(inputId, labelId) {
            const input = document.getElementById(inputId);
            const label = document.getElementById(labelId);
            
            if (input.files && input.files.length > 0) {
                const fileName = input.files[0].name;
                // Ubah isi label jadi nama file
                label.innerHTML = `
                    <svg class="w-8 h-8 text-green-500 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="text-xs text-green-700 font-bold truncate px-2">${fileName}</span>
                `;
                label.classList.add('bg-white', 'border-solid');
            }
        }
    </script>
</body>
</html>