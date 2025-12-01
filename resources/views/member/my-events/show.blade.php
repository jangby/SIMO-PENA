<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">
        
        <div class="relative h-64 bg-[#83218F]">
            @if($registration->event->banner)
                <img src="{{ asset('storage/' . $registration->event->banner) }}" class="w-full h-full object-cover opacity-50">
            @else
                <div class="w-full h-full bg-gradient-to-br from-[#83218F] to-purple-900 opacity-80"></div>
            @endif
            
            <a href="{{ route('my-events.index') }}" class="absolute top-6 left-4 p-2 bg-black/20 backdrop-blur-md rounded-full text-white hover:bg-black/40 transition z-20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>

            <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-black/80 to-transparent pt-20">
                <span class="bg-yellow-400 text-[#83218F] text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide shadow-sm">
                    {{ $registration->event->type }}
                </span>
                <h1 class="text-white font-bold text-2xl mt-2 leading-tight shadow-black drop-shadow-md">{{ $registration->event->title }}</h1>
                <p class="text-white/90 text-xs mt-1 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $registration->event->location }}
                </p>
            </div>
        </div>

        <div class="px-4 mt-6 max-w-xl mx-auto space-y-6">
            
            @if($registration->status == 'approved')
                <div class="bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-green-800 text-sm">Pendaftaran Diterima</h3>
                            <p class="text-xs text-green-600">Anda peserta resmi kegiatan ini.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-yellow-800 text-sm">Menunggu Verifikasi</h3>
                            <p class="text-xs text-yellow-600">Admin sedang mengecek data Anda.</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                
                <a href="{{ route('my-events.id-card', $registration->id) }}" id="tour-idcard" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group {{ $registration->status != 'approved' ? 'opacity-50 pointer-events-none' : '' }}">
                    <div class="w-12 h-12 bg-purple-50 text-[#83218F] rounded-2xl flex items-center justify-center mb-3 group-hover:bg-[#83218F] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">ID Card & Barcode</span>
                    <span class="text-[10px] text-gray-400 mt-1">Untuk Absensi</span>
                </a>

                <button onclick="document.getElementById('rundownModal').showModal()" id="tour-rundown" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">Jadwal Acara</span>
                    <span class="text-[10px] text-gray-400 mt-1">Susunan Kegiatan</span>
                </button>

                @if($registration->presence_at && $registration->certificate_file)
                    
                    <a href="{{ route('my-events.certificate.download', $registration->id) }}" class="bg-white p-5 rounded-3xl shadow-sm border border-green-200 flex flex-col items-center justify-center hover:shadow-md transition group hover:bg-green-50">
                        <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-110 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </div>
                        <span class="font-bold text-sm text-gray-800">Download PDF</span>
                        <span class="text-[10px] text-green-600 mt-1 font-bold">Simpan ke HP</span>
                    </a>

                @else
                    
                    <button onclick="
                        @if(!$registration->presence_at) 
                            alert('Anda belum melakukan Absensi Kehadiran.') 
                        @else 
                            alert('Sertifikat Anda sedang diproses oleh Admin. Silakan cek berkala.') 
                        @endif
                    " id="tour-cert" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center opacity-60 cursor-not-allowed grayscale">
                        <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <span class="font-bold text-sm text-gray-500">E-Sertifikat</span>
                        <span class="text-[10px] text-gray-400 mt-1">
                            @if(!$registration->presence_at) Belum Hadir @else Proses Penerbitan @endif
                        </span>
                    </button>

                @endif

                <button onclick="alert('Dokumentasi belum tersedia')" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group opacity-50">
                    <div class="w-12 h-12 bg-pink-50 text-pink-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">Dokumentasi</span>
                    <span class="text-[10px] text-gray-400 mt-1">Galeri Foto</span>
                </button>
            </div>

        </div>
    </div>

    <dialog id="rundownModal" class="modal rounded-3xl p-0 w-full max-w-md backdrop:bg-black/50">
        <div class="bg-white h-[85vh] flex flex-col">
            <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50 sticky top-0 z-10">
                <div>
                    <h3 class="font-bold text-lg text-gray-800">Susunan Acara</h3>
                    <p class="text-xs text-gray-500">{{ $registration->event->title }}</p>
                </div>
                <button onclick="document.getElementById('rundownModal').close()" class="bg-white border border-gray-200 p-2 rounded-full hover:bg-gray-100 text-gray-500 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 p-5">
                @if($groupedSchedules->isEmpty())
                    <div class="text-center py-10">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-gray-500 text-sm">Jadwal belum dirilis panitia.</p>
                    </div>
                @else
                    <div class="space-y-8">
                        @foreach($groupedSchedules as $date => $schedules)
                        <div class="relative">
                            <div class="sticky top-0 z-10 bg-white/90 backdrop-blur-sm py-2 mb-4 border-b border-dashed border-gray-200">
                                <span class="bg-[#83218F] text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                                </span>
                            </div>
                            <div class="border-l-2 border-purple-100 ml-3 space-y-6 pb-2">
                                @foreach($schedules as $schedule)
                                <div class="relative pl-6 group">
                                    <span class="absolute -left-[7px] top-1.5 w-3.5 h-3.5 bg-white border-2 border-[#83218F] rounded-full group-hover:bg-[#83218F] transition"></span>
                                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100 group-hover:border-purple-200 group-hover:bg-purple-50 transition">
                                        <div class="flex justify-between items-start mb-1">
                                            <h4 class="font-bold text-gray-800 text-sm leading-tight">{{ $schedule->activity }}</h4>
                                            <span class="text-[10px] font-bold bg-white text-[#83218F] border border-purple-100 px-2 py-0.5 rounded shadow-sm whitespace-nowrap ml-2">
                                                {{ $schedule->start_time->format('H:i') }}
                                            </span>
                                        </div>
                                        @if($schedule->pic)
                                            <div class="flex items-center gap-1 mt-1 text-xs text-gray-500">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $schedule->pic }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </dialog>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css"/>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah ada parameter ?start_tour=true
            const urlParams = new URLSearchParams(window.location.search);
            // Kita gunakan logika ini hanya jika parameter ada
            if (urlParams.get('start_tour') === 'true') {
                
                // Hapus parameter agar tidak muncul lagi saat refresh
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({path: newUrl}, '', newUrl);

                const driver = window.driver.js.driver;
                const tour = driver({
                    showProgress: true,
                    animate: true,
                    allowClose: false,
                    doneBtnText: 'Siap Menggunakan!',
                    nextBtnText: 'Lanjut',
                    prevBtnText: 'Kembali',
                    steps: [
                        { 
                            element: '#tour-idcard', 
                            popover: { 
                                title: 'ID Card & Absensi 🎟️', 
                                description: 'Klik di sini untuk mendapatkan <b>Barcode</b> absensi dan Kartu Peserta Digital Anda. Tunjukkan pada panitia saat acara.',
                                side: "bottom"
                            } 
                        },
                        { 
                            element: '#tour-rundown', 
                            popover: { 
                                title: 'Jadwal Kegiatan 📅', 
                                description: 'Lihat susunan acara lengkap di sini agar tidak ketinggalan sesi materi.',
                                side: "bottom"
                            } 
                        },
                        { 
                            element: '#tour-cert', 
                            popover: { 
                                title: 'Sertifikat Digital 🎓', 
                                description: 'Setelah acara selesai, E-Sertifikat Anda akan tersedia dan bisa diunduh di sini.',
                                side: "top"
                            } 
                        }
                    ]
                });

                // Mulai Tour
                setTimeout(() => {
                    tour.drive();
                }, 500);
            }
        });
    </script>
</x-app-layout>