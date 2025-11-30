<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tulis Artikel Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            
                            <div class="mb-6">
                                <input type="text" name="title" 
                                       class="w-full border-0 border-b-2 border-gray-200 px-0 py-3 text-2xl font-bold text-gray-800 placeholder-gray-300 focus:border-[#83218F] focus:ring-0 transition" 
                                       placeholder="Judul Artikel..." value="{{ old('title') }}" required>
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Isi Konten</label>
                                <textarea name="content" rows="15" 
                                          class="w-full border-gray-200 rounded-xl px-4 py-4 text-gray-700 leading-relaxed focus:ring-[#83218F] focus:border-[#83218F]" 
                                          placeholder="Mulai menulis cerita..." required>{{ old('content') }}</textarea>
                                @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 text-sm">Publikasi</h3>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Status</label>
                                <select name="status" class="w-full border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-[#83218F] focus:border-[#83218F]">
                                    <option value="published">Langsung Terbitkan</option>
                                    <option value="draft">Simpan Konsep (Draft)</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-3 pt-2">
                                <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                                    PUBLIKASIKAN
                                </button>
                                <a href="{{ route('admin.articles.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-4 rounded-xl text-center transition text-sm">
                                    Batal
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Gambar Sampul</label>
                            
                            <div class="relative w-full aspect-video bg-gray-50 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-[#83218F] transition group cursor-pointer">
                                <input type="file" name="thumbnail" id="thumbInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewThumb(event)">
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#83218F]" id="thumbPlaceholder">
                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-bold">Pilih Gambar</span>
                                </div>
                                <img id="thumbPreview" class="hidden w-full h-full object-cover">
                            </div>
                            @error('thumbnail') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewThumb(event) {
            const input = event.target;
            const preview = document.getElementById('thumbPreview');
            const placeholder = document.getElementById('thumbPlaceholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>