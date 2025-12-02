<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Organisasi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.organizations.update', $organization->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            
                            <div class="mb-6">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Nama Organisasi</label>
                                <input type="text" name="name" 
                                       class="w-full border-gray-200 rounded-xl px-4 py-3 text-gray-800 placeholder-gray-300 focus:border-[#83218F] focus:ring-[#83218F] transition" 
                                       value="{{ old('name', $organization->name) }}" required>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Alamat Lengkap</label>
                                <textarea name="address" rows="5" 
                                          class="w-full border-gray-200 rounded-xl px-4 py-3 text-gray-700 leading-relaxed focus:ring-[#83218F] focus:border-[#83218F]" 
                                          >{{ old('address', $organization->address) }}</textarea>
                                @error('address') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="font-bold text-gray-800 mb-4 text-sm">Pengaturan</h3>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Tingkatan (Type)</label>
                                <select name="type" class="w-full border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-[#83218F] focus:border-[#83218F]">
                                    <option value="PR" {{ old('type', $organization->type) == 'PR' ? 'selected' : '' }}>PR (Ranting / Desa)</option>
                                    <option value="PK" {{ old('type', $organization->type) == 'PK' ? 'selected' : '' }}>PK (Komisariat / Sekolah)</option>
                                    <option value="PAC" {{ old('type', $organization->type) == 'PAC' ? 'selected' : '' }}>PAC (Kecamatan)</option>
                                </select>
                            </div>

                            <div class="flex flex-col gap-3 pt-2">
                                <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    UPDATE DATA
                                </button>
                                <a href="{{ route('admin.organizations.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-4 rounded-xl text-center transition text-sm">
                                    Batal
                                </a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Logo Organisasi</label>
                            
                            <div class="relative w-full aspect-square bg-gray-50 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-[#83218F] transition group cursor-pointer">
                                <input type="file" name="logo" id="thumbInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewThumb(event)">
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#83218F] {{ $organization->logo ? 'hidden' : '' }}" id="thumbPlaceholder">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-[10px] font-bold">Ganti Logo</span>
                                </div>
                                <img id="thumbPreview" src="{{ $organization->logo ? asset('storage/' . $organization->logo) : '' }}" class="{{ $organization->logo ? '' : 'hidden' }} w-full h-full object-cover">
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2 text-center">Biarkan kosong jika tidak ingin mengganti logo.</p>
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