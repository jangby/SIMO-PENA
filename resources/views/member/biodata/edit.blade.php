<x-app-layout>
    <style>nav[x-data] { display: none !important; }</style>

    <div class="min-h-screen bg-gray-50 font-sans pb-12">

        <div class="bg-[#83218F] pt-8 pb-14 px-4 sticky top-0 z-0 shadow-md rounded-b-[2rem]">
            <div class="flex items-center justify-between max-w-xl mx-auto">
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 rounded-xl text-white hover:bg-white/20 transition backdrop-blur-md border border-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-white font-bold text-lg tracking-wide">Edit Profil</h1>
                <div class="w-10"></div>
            </div>
        </div>

        <div class="px-4 -mt-10 relative z-40 max-w-xl mx-auto">
            
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-xl shadow-sm flex justify-between items-center animate-pulse">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span class="font-bold text-sm">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl shadow-sm">
                    <div class="font-bold text-sm mb-1">Gagal Menyimpan!</div>
                    <ul class="list-disc list-inside text-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('biodata.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="bg-white rounded-3xl shadow-xl overflow-visible mb-6 border border-gray-100">
                    <div class="p-6 pb-8">
                        <div class="flex flex-col items-center -mt-16">
                            <div class="relative group">
                                <div class="w-28 h-28 rounded-full border-[5px] border-white shadow-lg overflow-hidden bg-gray-100 relative">
                                    @if($profile && $profile->photo)
                                        <img src="{{ asset('storage/' . $profile->photo) }}" class="w-full h-full object-cover" id="photo-preview">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-purple-50 text-[#83218F] text-3xl font-bold" id="photo-placeholder">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <img src="" class="w-full h-full object-cover hidden" id="photo-preview-img">
                                    @endif
                                </div>
                                <label for="photo" class="absolute bottom-0 right-0 bg-[#83218F] text-white p-2 rounded-full shadow-md border-[3px] border-white cursor-pointer hover:bg-purple-800 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </label>
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <h2 class="mt-3 font-bold text-gray-800 text-lg">{{ $user->name }}</h2>
                            <p class="text-xs text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-lg p-6 space-y-5 border border-gray-100">
                    <h3 class="text-sm font-bold text-[#83218F] uppercase tracking-wider border-b border-gray-100 pb-2 mb-4">Biodata Diri</h3>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Asal Sekolah</label>
                        <input type="text" name="school_origin" value="{{ old('school_origin', $profile->school_origin ?? '') }}" 
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                        @error('school_origin') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Tempat Lahir</label>
                            <input type="text" name="birth_place" value="{{ old('birth_place', $profile->birth_place ?? '') }}" 
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center">
                            @error('birth_place') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Tanggal Lahir</label>
                            <input type="date" name="birth_date" value="{{ old('birth_date', $profile->birth_date ?? '') }}" 
                                   class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm text-center">
                            @error('birth_date') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">WhatsApp</label>
                        <input type="number" name="phone" value="{{ old('phone', $profile->phone ?? '') }}" 
                               class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm">
                        @error('phone') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2 ml-1">Jenis Kelamin</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="gender" value="L" class="peer sr-only" {{ (old('gender', $profile->gender ?? '') == 'L') ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-100 bg-gray-50 p-3 text-center peer-checked:border-[#83218F] peer-checked:bg-purple-50 transition">
                                    <span class="block text-sm font-bold text-gray-500 peer-checked:text-[#83218F]">Laki-laki</span>
                                </div>
                            </label>
                            <label class="cursor-pointer relative">
                                <input type="radio" name="gender" value="P" class="peer sr-only" {{ (old('gender', $profile->gender ?? '') == 'P') ? 'checked' : '' }}>
                                <div class="rounded-xl border-2 border-gray-100 bg-gray-50 p-3 text-center peer-checked:border-[#83218F] peer-checked:bg-purple-50 transition">
                                    <span class="block text-sm font-bold text-gray-500 peer-checked:text-[#83218F]">Perempuan</span>
                                </div>
                            </label>
                        </div>
                        @error('gender') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Alamat Lengkap</label>
                        <textarea name="address" rows="3" 
                                  class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition p-3 text-sm">{{ old('address', $profile->address ?? '') }}</textarea>
                        @error('address') <span class="text-red-500 text-xs ml-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-[#83218F] text-white py-4 rounded-xl font-bold text-sm uppercase tracking-wider shadow-lg shadow-purple-200 hover:bg-purple-800 transition transform active:scale-95 flex justify-center items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('photo-preview');
                var placeholder = document.getElementById('photo-placeholder');
                var imgHidden = document.getElementById('photo-preview-img');
                if(output) {
                    output.src = reader.result;
                } else if (placeholder && imgHidden) {
                    placeholder.style.display = 'none';
                    imgHidden.src = reader.result;
                    imgHidden.classList.remove('hidden');
                    imgHidden.id = 'photo-preview'; 
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>