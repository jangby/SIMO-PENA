<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Dokumentasi Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Judul / Keterangan Foto</label>
                        <input type="text" name="title" class="w-full text-lg font-bold border-0 border-b-2 border-gray-200 px-0 py-2 focus:ring-0 focus:border-[#83218F] transition placeholder-gray-300" placeholder="Misal: Pelantikan Pengurus 2025" required>
                        @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">File Foto</label>
                        
                        <div class="relative w-full h-80 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 hover:border-[#83218F] transition flex flex-col items-center justify-center cursor-pointer group overflow-hidden">
                            
                            <input type="file" name="image" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20" accept="image/*" onchange="previewImage(event)">
                            
                            <div class="text-center transition duration-300 group-hover:scale-105 z-10" id="placeholder">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center text-gray-400 shadow-sm mx-auto mb-3 group-hover:text-[#83218F]">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">Klik atau geser foto ke sini</p>
                                <p class="text-gray-400 text-xs mt-1">JPG, PNG (Max 5MB)</p>
                            </div>

                            <img id="imagePreview" class="absolute inset-0 w-full h-full object-contain bg-black/5 hidden z-10">
                        </div>
                        @error('image') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center gap-4 border-t border-gray-100 pt-6">
                        <button type="submit" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Simpan ke Galeri
                        </button>
                        <a href="{{ route('admin.galleries.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-800 px-4">Batal</a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); // Tampilkan gambar
                    placeholder.classList.add('hidden'); // Sembunyikan teks placeholder
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>