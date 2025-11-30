<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pengurus Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.structures.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <div class="md:col-span-1">
                        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 text-center sticky top-6">
                            <h3 class="font-bold text-gray-700 text-sm mb-4">Foto Profil</h3>
                            
                            <div class="relative w-40 h-40 mx-auto mb-4 group">
                                <div class="w-full h-full rounded-full overflow-hidden border-4 border-purple-50 bg-gray-100 shadow-inner flex items-center justify-center relative">
                                    <img id="photoPreview" class="w-full h-full object-cover hidden">
                                    <div id="photoPlaceholder" class="text-gray-400 flex flex-col items-center">
                                        <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="text-[10px] font-bold uppercase">No Image</span>
                                    </div>
                                </div>
                                
                                <label for="photoInput" class="absolute bottom-1 right-1 bg-[#83218F] text-white p-2.5 rounded-full shadow-lg cursor-pointer hover:bg-purple-800 transition transform hover:scale-110 border-4 border-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                            </div>

                            <p class="text-xs text-gray-400">Format: JPG, PNG. Max 2MB.</p>
                            <p class="text-xs text-red-500 mt-2 font-bold hidden" id="photoError">File terlalu besar!</p>
                            @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-lg text-gray-800 border-b border-gray-100 pb-4 mb-6">Informasi Jabatan</h3>
                            
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F] transition text-gray-800 font-semibold" placeholder="Contoh: Rekan Ahmad Fauzi" required>
                                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Jabatan</label>
                                        <input type="text" name="position" value="{{ old('position') }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Ketua" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Departemen / Bidang</label>
                                        <input type="text" name="department" value="{{ old('department') }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Kaderisasi">
                                        <p class="text-[10px] text-gray-400 mt-1">Kosongkan jika Pengurus Harian (BPH).</p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Level Urutan (1-99)</label>
                                        <div class="relative">
                                            <input type="number" name="level" value="{{ old('level') }}" class="w-full pl-4 pr-12 border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="1" required>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-xs font-bold text-gray-400">Order</div>
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">1 = Paling Atas (Ketua), 2 = Wakil, dst.</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Link Instagram (Opsional)</label>
                                        <input type="url" name="instagram_link" value="{{ old('instagram_link') }}" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="https://instagram.com/user">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-4">
                                <button type="submit" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Simpan Pengurus
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
            const errorMsg = document.getElementById('photoError');

            if (input.files && input.files[0]) {
                // Validasi Size (Max 2MB)
                if(input.files[0].size > 2048 * 1024) {
                    errorMsg.classList.remove('hidden');
                    input.value = ''; // Reset input
                    return;
                }
                errorMsg.classList.add('hidden');

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