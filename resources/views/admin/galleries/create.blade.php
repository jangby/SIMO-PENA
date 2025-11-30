<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Upload Dokumentasi</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Kegiatan / Caption</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Pelantikan Raya 2025" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">File Foto (JPG/PNG)</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                    <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 5MB)</p>
                                </div>
                                <input id="dropzone-file" name="image" type="file" class="hidden" accept="image/*" onchange="previewImage(event)" />
                            </label>
                        </div>
                        <p id="file-name" class="text-xs text-green-600 mt-2 font-bold"></p>
                        @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-[#83218F] text-white rounded-lg font-bold hover:bg-purple-800 shadow-md">Simpan Foto</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = "File terpilih: " + input.files[0].name;
            }
        }
    </script>
</x-admin-layout>