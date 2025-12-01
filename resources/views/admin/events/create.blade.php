<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Kegiatan Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Utama</h3>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nama Kegiatan</label>
                                <input type="text" name="title" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F] transition text-gray-800 font-semibold placeholder-gray-300" placeholder="Contoh: MAKESTA RAYA ZONA 1" required value="{{ old('title') }}">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Deskripsi Lengkap</label>
                                <textarea name="description" rows="6" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F] transition text-gray-600" placeholder="Tuliskan detail acara, persyaratan, dll..." required>{{ old('description') }}</textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Lokasi & Waktu
                            </h3>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Lokasi Kegiatan</label>
                                <div class="relative">
                                    <input type="text" name="location" class="w-full pl-10 border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Gedung MWC NU Limbangan" required value="{{ old('location') }}">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Waktu Mulai</label>
                                    <input type="datetime-local" name="start_time" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" required value="{{ old('start_time') }}">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Waktu Selesai</label>
                                    <input type="datetime-local" name="end_time" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" required value="{{ old('end_time') }}">
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Banner / Poster</label>
                            
                            <div class="relative w-full aspect-video bg-gray-100 rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-[#83218F] transition group cursor-pointer">
                                <input type="file" name="banner" id="bannerInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*" onchange="previewBanner(event)">
                                
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#83218F]" id="bannerPlaceholder">
                                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs font-bold">Upload Gambar</span>
                                </div>

                                <img id="bannerPreview" class="hidden w-full h-full object-cover">
                            </div>
                            <p class="text-[10px] text-gray-400 mt-2">Format: JPG, PNG. Max: 2MB.</p>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Jenis Kegiatan</label>
                                <select name="type" class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]">
                                    <option value="makesta">MAKESTA</option>
                                    <option value="lakmud">LAKMUD</option>
                                    <option value="rapat">RAPAT</option>
                                    <option value="lainnya">LAINNYA</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Biaya Pendaftaran</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">Rp</div>
                                    <input type="number" name="price" class="w-full pl-10 border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="0" value="{{ old('price', 0) }}">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1">Isi 0 jika gratis.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Biaya Pendaftaran</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500 font-bold">Rp</div>
                                    <input type="number" name="price" class="w-full pl-10 border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" placeholder="0" value="{{ old('price', 0) }}">
                                </div>
                            </div>

                            <div class="mb-4" x-data="{ 
                                accounts: [{ bank: '', number: '', name: '' }] 
                            }">
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 flex justify-between items-center">
                                    Rekening Pembayaran
                                    <button type="button" @click="accounts.push({ bank: '', number: '', name: '' })" class="text-[#83218F] hover:underline text-[10px] flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Bank
                                    </button>
                                </label>

                                <div class="space-y-3">
                                    <template x-for="(account, index) in accounts" :key="index">
                                        <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl space-y-2 relative group">
                                            
                                            <button type="button" @click="accounts.splice(index, 1)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500" x-show="accounts.length > 1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>

                                            <input type="text" :name="`bank_accounts[${index}][bank]`" x-model="account.bank" placeholder="Nama Bank / E-Wallet (Contoh: BRI / DANA)" class="w-full border-gray-200 rounded-lg text-xs px-3 py-2 focus:ring-[#83218F] focus:border-[#83218F]">
                                            
                                            <input type="number" :name="`bank_accounts[${index}][number]`" x-model="account.number" placeholder="Nomor Rekening" class="w-full border-gray-200 rounded-lg text-xs px-3 py-2 focus:ring-[#83218F] focus:border-[#83218F]">
                                            
                                            <input type="text" :name="`bank_accounts[${index}][name]`" x-model="account.name" placeholder="Atas Nama (Pemilik)" class="w-full border-gray-200 rounded-lg text-xs px-3 py-2 focus:ring-[#83218F] focus:border-[#83218F]">
                                        </div>
                                    </template>
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic">Klik "Tambah Bank" jika ada lebih dari satu tujuan transfer.</p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3">
                            <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                PUBLIKASIKAN
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
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-admin-layout>