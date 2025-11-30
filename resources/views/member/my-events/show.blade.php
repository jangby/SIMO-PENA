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
                <span class="bg-yellow-400 text-[#83218F] text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wide">
                    {{ $registration->event->type }}
                </span>
                <h1 class="text-white font-bold text-2xl mt-2 leading-tight">{{ $registration->event->title }}</h1>
                <p class="text-white/80 text-xs mt-1 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    {{ $registration->event->location }}
                </p>
            </div>
        </div>

        <div class="px-4 mt-6 max-w-xl mx-auto space-y-6">
            
            @if($registration->status == 'approved')
                <div class="bg-green-50 border border-green-200 p-4 rounded-2xl flex items-center justify-between">
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
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-2xl flex items-center justify-between">
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
                
                <a href="{{ route('my-events.id-card', $registration->id) }}" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group {{ $registration->status != 'approved' ? 'opacity-50 pointer-events-none' : '' }}">
                    <div class="w-12 h-12 bg-purple-50 text-[#83218F] rounded-2xl flex items-center justify-center mb-3 group-hover:bg-[#83218F] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">ID Card & Barcode</span>
                    <span class="text-[10px] text-gray-400 mt-1">Untuk Absensi</span>
                </a>

                <button onclick="document.getElementById('rundownModal').showModal()" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">Jadwal Acara</span>
                    <span class="text-[10px] text-gray-400 mt-1">Susunan Kegiatan</span>
                </button>

                <button onclick="alert('Sertifikat belum diterbitkan')" class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col items-center justify-center hover:shadow-md transition group opacity-50">
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="font-bold text-sm text-gray-800">E-Sertifikat</span>
                    <span class="text-[10px] text-gray-400 mt-1">Belum Tersedia</span>
                </button>

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

    <dialog id="rundownModal" class="modal rounded-3xl p-0 w-full max-w-sm backdrop:bg-black/50">
        <div class="bg-white p-6 h-[80vh] flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Jadwal Kegiatan</h3>
                <button onclick="document.getElementById('rundownModal').close()" class="bg-gray-100 p-2 rounded-full hover:bg-gray-200">✕</button>
            </div>
            
            <div class="overflow-y-auto flex-1 space-y-4">
                @forelse($registration->event->schedules as $schedule)
                <div class="flex gap-4 border-b border-gray-50 pb-4">
                    <div class="text-xs font-bold text-gray-500 pt-1 w-16">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm">{{ $schedule->activity }}</h4>
                        <p class="text-xs text-gray-500 mt-1">PIC: {{ $schedule->pic ?? '-' }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm mt-10">Jadwal belum dirilis panitia.</p>
                @endforelse
            </div>
        </div>
    </dialog>
</x-app-layout>