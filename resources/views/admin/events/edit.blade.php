<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kegiatan: <span class="text-[#83218F]">{{ $event->title }}</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Utama</h3>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nama Kegiatan</label>
                                <input type="text" name="title" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" value="{{ old('title', $event->title) }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Deskripsi Lengkap</label>
                                <textarea name="description" rows="6" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" required>{{ old('description', $event->description) }}</textarea>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Lokasi & Waktu</h3>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Lokasi</label>
                                <input type="text" name="location" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" value="{{ old('location', $event->location) }}" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Waktu Mulai</label>
                                    <input type="datetime-local" name="start_time" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Waktu Selesai</label>
                                    <input type="datetime-local" name="end_time" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" value="{{ old('end_time', $event->end_time->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Banner / Poster</label>
                            
                            <div class="relative w-full aspect-video bg-gray-100 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-[#83218F] transition group cursor-pointer">
                                <input type="file" name="banner" id="bannerInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewBanner(event)">
                                
                                @if($event->banner)
                                    <img id="bannerPreview" src="{{ asset('storage/' . $event->banner) }}" class="w-full h-full object-cover">
                                    <div id="bannerPlaceholder" class="hidden absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                        <span class="text-xs font-bold">Ganti Gambar</span>
                                    </div>
                                @else
                                    <div id="bannerPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#83218F]">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs font-bold">Upload Gambar</span>
                                    </div>
                                    <img id="bannerPreview" class="hidden w-full h-full object-cover">
                                @endif
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Jenis Kegiatan</label>
                                <select name="type" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]">
                                    <option value="makesta" {{ old('type', $event->type) == 'makesta' ? 'selected' : '' }}>MAKESTA</option>
                                    <option value="lakmud" {{ old('type', $event->type) == 'lakmud' ? 'selected' : '' }}>LAKMUD</option>
                                    <option value="rapat" {{ old('type', $event->type) == 'rapat' ? 'selected' : '' }}>RAPAT</option>
                                    <option value="lainnya" {{ old('type', $event->type) == 'lainnya' ? 'selected' : '' }}>LAINNYA</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Biaya</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">Rp</div>
                                    <input type="number" name="price" class="w-full pl-10 border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" value="{{ old('price', $event->price) }}">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition transform active:scale-95">
                                SIMPAN PERUBAHAN
                            </button>
                            <a href="{{ route('admin.events.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3.5 px-4 rounded-xl text-center transition">
                                Batal
                            </a>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        function previewBanner(event) {
            const input = event.target;
            const preview = document.getElementById('bannerPreview');
            const placeholder = document.getElementById('bannerPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if(placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>