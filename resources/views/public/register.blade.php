<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar: {{ $event->title }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="bg-[#83218F] pt-6 pb-32 px-4 relative rounded-b-[3rem] shadow-lg">
        <div class="max-w-xl mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="p-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white hover:bg-white/20 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-white font-bold text-lg tracking-wide">Formulir Pendaftaran</h1>
            <div class="w-10"></div>
        </div>

        <div class="max-w-xl mx-auto mt-8 text-center text-white px-4">
            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-[10px] font-bold uppercase tracking-widest mb-3 border border-white/10 shadow-sm">
                {{ $event->type }}
            </span>
            <h2 class="text-2xl font-extrabold leading-tight mb-4">{{ $event->title }}</h2>
            
            <div class="mb-4">
                @if($event->price > 0)
                    <div class="inline-flex flex-col items-center bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-yellow-400/30 shadow-lg">
                        <span class="text-[10px] text-yellow-200 uppercase tracking-widest font-bold mb-1">Biaya Pendaftaran</span>
                        <span class="text-2xl font-black text-yellow-300 tracking-tight">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <span class="inline-block px-4 py-2 bg-green-500/20 text-green-300 font-bold rounded-lg border border-green-400/30">
                        GRATIS (FREE)
                    </span>
                @endif
            </div>

            <div class="flex justify-center items-center gap-4 text-purple-200 text-xs font-medium">
                <span class="flex items-center bg-white/10 px-3 py-1 rounded-full"><svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> {{ $event->start_time->format('d M Y') }}</span>
                <span class="flex items-center bg-white/10 px-3 py-1 rounded-full"><svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg> {{ Str::limit($event->location, 15) }}</span>
            </div>
        </div>
    </div>

    <div class="max-w-xl mx-auto px-4 -mt-12 relative z-10 pb-20">
        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
            
            <form method="POST" action="{{ route('event.store', $event->id) }}" enctype="multipart/form-data" id="registerForm">
                @csrf

                <div class="p-6 space-y-6">
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm font-semibold placeholder-gray-400" placeholder="Sesuai KTP/Identitas" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 ml-1">Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="gender" value="L" class="peer sr-only" {{ old('gender') == 'L' ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-100 bg-gray-50 p-3 text-center transition-all peer-checked:border-[#83218F] peer-checked:bg-purple-50 peer-checked:text-[#83218F] shadow-sm">
                                    <span class="block text-sm font-bold">Laki-laki (IPNU)</span>
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="gender" value="P" class="peer sr-only" {{ old('gender') == 'P' ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-100 bg-gray-50 p-3 text-center transition-all peer-checked:border-[#83218F] peer-checked:bg-purple-50 peer-checked:text-[#83218F] shadow-sm">
                                    <span class="block text-sm font-bold">Perempuan (IPPNU)</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center" placeholder="Kota" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Nomor WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="number" name="phone" value="{{ old('phone') }}" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm font-semibold placeholder-gray-400" placeholder="08xxxxxxxxxx" required>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-1 mb-1.5 ml-1">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Delegasi</label>
                            
                            <button type="button" onclick="showInfoDelegasi()" class="text-gray-400 hover:text-[#83218F] transition focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </button>
                        </div>
                        
                        <input type="text" name="school_origin" value="{{ old('school_origin') }}" 
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" 
                               placeholder="Contoh: PR IPNU Desa Limbangan / PK SMA 1" required>
                        
                        @error('school_origin') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-purple-50/50 p-5 rounded-2xl border border-purple-100 space-y-4">
                        <h3 class="text-xs font-bold text-[#83218F] uppercase tracking-widest border-b border-purple-100 pb-2 mb-2">Alamat Lengkap</h3>
                        
                        <input type="text" name="addr_street" value="{{ old('addr_street') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm" placeholder="Nama Dusun / Jalan / Blok" required>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-gray-500 w-8">RT</span>
                                <input type="number" name="addr_rt" value="{{ old('addr_rt') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm text-center" placeholder="00" required>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-gray-500 w-8">RW</span>
                                <input type="number" name="addr_rw" value="{{ old('addr_rw') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm text-center" placeholder="00" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="addr_village" value="{{ old('addr_village') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm" placeholder="Desa / Kel" required>
                            <input type="text" name="addr_district" value="{{ old('addr_district', 'Limbangan') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm" placeholder="Kecamatan" required>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" name="addr_regency" value="{{ old('addr_regency', 'Garut') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm" placeholder="Kabupaten" required>
                            <input type="number" name="addr_postal" value="{{ old('addr_postal') }}" class="block w-full rounded-xl border-gray-200 focus:border-[#83218F] focus:ring-[#83218F] text-sm" placeholder="Kode Pos">
                        </div>
                    </div>

                    <div class="border-t border-gray-100"></div>

                    @if($event->price > 0)
                    <div class="bg-white rounded-2xl p-4 border border-gray-200 shadow-sm">
                        <label class="block text-xs font-bold text-gray-800 uppercase tracking-wide mb-3">
                            Transfer Pembayaran (Rp {{ number_format($event->price, 0, ',', '.') }})
                        </label>
                        
                        <div class="space-y-2 mb-4">
                             @if(!empty($event->bank_accounts))
                                @foreach($event->bank_accounts as $bank)
                                <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-purple-100 text-[#83218F] rounded-lg flex items-center justify-center font-bold text-[10px] uppercase shadow-sm">
                                            {{ substr($bank['bank'], 0, 4) }}
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-500 uppercase">{{ $bank['bank'] }}</p>
                                            <p class="text-xs font-black text-gray-800 tracking-wide">{{ $bank['number'] }}</p>
                                        </div>
                                    </div>
                                    <button type="button" onclick="navigator.clipboard.writeText('{{ $bank['number'] }}'); Swal.fire({icon: 'success', title: 'Disalin!', text: 'No Rekening berhasil disalin.', timer: 1500, showConfirmButton: false});" class="text-gray-400 hover:text-[#83218F]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="relative">
                            <input type="file" name="payment_proof" id="payment_proof" class="hidden" accept="image/*" onchange="validateFile(this, 'payment-label', 'Bukti Transfer')" required>
                            <label for="payment_proof" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-[#83218F]/30 rounded-xl cursor-pointer hover:bg-purple-50 transition group" id="payment-label">
                                <div class="w-8 h-8 bg-purple-50 rounded-full flex items-center justify-center text-[#83218F] mb-1 group-hover:scale-110 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">Upload Bukti Transfer</span>
                            </label>
                        </div>
                    </div>
                    @endif

                    @if($event->type == 'lakmud')
                    <div class="bg-yellow-50 rounded-2xl p-4 border border-yellow-200">
                        <label class="block text-xs font-bold text-yellow-700 uppercase tracking-wide mb-2">Sertifikat Makesta</label>
                        <div class="relative">
                            <input type="file" name="certificate_file" id="certificate_file" class="hidden" accept="image/*,application/pdf" onchange="validateFile(this, 'cert-label', 'Sertifikat')" required>
                            <label for="certificate_file" class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-yellow-400/50 rounded-xl cursor-pointer hover:bg-white transition" id="cert-label">
                                <span class="text-xs text-yellow-600 font-medium">Upload File</span>
                            </label>
                        </div>
                    </div>
                    @endif

                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-100">
                    <button type="submit" class="w-full bg-[#83218F] text-white py-4 rounded-xl font-bold shadow-lg shadow-purple-200 hover:bg-purple-800 transition transform active:scale-95 flex justify-center items-center uppercase tracking-wide text-sm">
                        Kirim Pendaftaran
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function showInfoDelegasi() {
            Swal.fire({
                title: 'Apa itu Delegasi?',
                html: `
                    <div class="text-left text-sm text-gray-600 space-y-3">
                        <p><strong>Delegasi</strong> adalah asal kepengurusan atau lembaga yang mengutus Anda mengikuti acara ini.</p>
                        <ul class="list-disc list-inside">
                            <li>Jika dari Sekolah/Pesantren, tulis <strong>PK</strong> (Pimpinan Komisariat). <br><em>Contoh: PK IPNU/IPPNU Ma'arif atau PK IPNU/IPPNU Pesantren Assa'adah</em></li>
                            <li>Jika dari Desa/Kampung, tulis <strong>PR</strong> (Pimpinan Ranting). <br><em>Contoh: PR IPNU/IPPNU Desa Limbangan</em></li>
                            <li>Jika dari Kecamatan, tulis <strong>PAC</strong> (Pimpinan Anak Cabang). <br><em>Contoh: PAC IPNU/IPPNU Kecamatan Limbangan</em></li>
                            <li>Jika dari Kabupaten, tulis <strong>PC</strong> (Pimpinan Cabang). <br><em>Contoh: PC IPNU/IPPNU Kab. Garut</em></li>
                        </ul>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Saya Paham',
                confirmButtonColor: '#83218F',
                customClass: {
                    popup: 'rounded-3xl', // Biar sudutnya tumpul modern
                    title: 'text-[#83218F] font-bold'
                }
            });
        }
        // 1. Menangkap Error dari Laravel (Server Side)
        @if ($errors->any())
            let errorMsg = '';
            
            // Cek Error Spesifik
            @if($errors->has('phone'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Pendaftaran Gagal!',
                    text: "{!! $errors->first('phone') !!}", // Pesan duplikat dari controller
                    confirmButtonColor: '#83218F'
                });
            @elseif($errors->has('payment_proof') || $errors->has('certificate_file'))
                Swal.fire({
                    icon: 'error',
                    title: 'File Bermasalah',
                    text: 'Pastikan file yang diupload adalah Gambar/PDF dan ukurannya dibawah 2MB.',
                    confirmButtonColor: '#d33'
                });
            @else
                Swal.fire({
                    icon: 'error',
                    title: 'Data Belum Lengkap',
                    text: 'Silakan periksa kembali formulir Anda. Ada kolom yang belum terisi dengan benar.',
                    confirmButtonColor: '#d33'
                });
            @endif
        @endif

        // 2. Validasi Client Side (Saat Pilih File)
        function validateFile(input, labelId, typeName) {
            const label = document.getElementById(labelId);
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileSize = file.size / 1024 / 1024; // dalam MB

                // Cek Ukuran (Max 2MB)
                if (fileSize > 2) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar!',
                        text: `Ukuran file ${typeName} maksimal 2MB. File Anda: ${fileSize.toFixed(2)}MB`,
                        confirmButtonColor: '#83218F'
                    });
                    input.value = ''; // Reset input
                    return;
                }

                // Jika Aman, Ubah Label jadi Nama File
                label.innerHTML = `
                    <div class="flex items-center gap-2 text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold truncate max-w-[200px]">${file.name}</span>
                    </div>
                `;
                label.classList.add('bg-green-50', 'border-green-200');
                label.classList.remove('border-dashed');
            }
        }
    </script>
</body>
</html>