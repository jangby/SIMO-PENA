<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Pengurus
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.structures.update', $structure->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="md:col-span-1">
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center">
                            <h3 class="font-bold text-gray-700 text-sm mb-4">Foto Profil</h3>
                            
                            <div class="relative w-40 h-40 mx-auto mb-4 group">
                                <div class="w-full h-full rounded-full overflow-hidden border-4 border-purple-50 bg-gray-100 shadow-inner flex items-center justify-center relative">
                                    @if($structure->photo)
                                        <img id="photoPreview" src="{{ asset('storage/' . $structure->photo) }}" class="w-full h-full object-cover">
                                        <div id="photoPlaceholder" class="hidden text-gray-400 flex flex-col items-center">...</div>
                                    @else
                                        <img id="photoPreview" class="w-full h-full object-cover hidden">
                                        <div id="photoPlaceholder" class="text-gray-400 flex flex-col items-center">
                                            <span class="text-2xl font-bold">{{ substr($structure->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <label for="photoInput" class="absolute bottom-1 right-1 bg-[#83218F] text-white p-2.5 rounded-full shadow-lg cursor-pointer hover:bg-purple-800 transition transform hover:scale-110 border-4 border-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah foto.</p>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-lg text-gray-800 border-b border-gray-100 pb-4 mb-6">Informasi Jabatan</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', $structure->name) }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F] text-gray-800 font-semibold" required>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Jabatan</label>
                                        <input type="text" name="position" value="{{ old('position', $structure->position) }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Departemen</label>
                                        <input type="text" name="department" value="{{ old('department', $structure->department) }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]">
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Level Urutan</label>
                                        <input type="number" name="level" value="{{ old('level', $structure->level) }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Link Instagram</label>
                                        <input type="url" name="instagram_link" value="{{ old('instagram_link', $structure->instagram_link) }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-4">
                                <button type="submit" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.structures.index') }}" class="text-gray-500 font-bold text-sm hover:text-gray-800 px-4">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('photoPreview');
            const placeholder = document.getElementById('photoPlaceholder');

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