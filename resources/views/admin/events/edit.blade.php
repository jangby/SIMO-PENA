<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Kegiatan: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.events.index') }}" class="inline-flex items-center mb-4 text-gray-500 hover:text-gray-700 text-sm">
                &larr; Kembali ke Daftar
            </a>

            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    @method('PUT') <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" 
                               value="{{ old('title', $event->title) }}" required>
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Kegiatan</label>
                            <select name="type" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                <option value="makesta" {{ old('type', $event->type) == 'makesta' ? 'selected' : '' }}>MAKESTA</option>
                                <option value="lakmud" {{ old('type', $event->type) == 'lakmud' ? 'selected' : '' }}>LAKMUD</option>
                                <option value="rapat" {{ old('type', $event->type) == 'rapat' ? 'selected' : '' }}>RAPAT</option>
                                <option value="lainnya" {{ old('type', $event->type) == 'lainnya' ? 'selected' : '' }}>LAINNYA</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Biaya (0 jika gratis)</label>
                            <input type="number" name="price" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" 
                                   value="{{ old('price', $event->price) }}">
                            @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" 
                                   value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}" required>
                            @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" 
                                   value="{{ old('end_time', $event->end_time->format('Y-m-d\TH:i')) }}" required>
                            @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Lokasi Kegiatan</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" 
                               value="{{ old('location', $event->location) }}" required>
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Deskripsi Lengkap</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>{{ old('description', $event->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Banner / Poster</label>
                        
                        @if($event->banner)
                            <div class="mb-2 p-2 border rounded bg-gray-50 inline-block">
                                <p class="text-xs text-gray-500 mb-1">Banner Saat Ini:</p>
                                <img src="{{ asset('storage/' . $event->banner) }}" alt="Current Banner" class="h-32 rounded shadow-sm">
                            </div>
                        @endif

                        <input type="file" name="banner" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-500" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah banner.</p>
                        @error('banner') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 flex gap-4">
                        <a href="{{ route('admin.events.index') }}" class="w-1/3 bg-gray-200 text-gray-700 py-2 px-4 rounded-lg font-bold text-center hover:bg-gray-300">
                            Batal
                        </a>
                        <button type="submit" class="w-2/3 bg-green-700 text-white py-2 px-4 rounded-lg font-bold hover:bg-green-800">
                            SIMPAN PERUBAHAN
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>