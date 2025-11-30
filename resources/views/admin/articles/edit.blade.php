<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Artikel</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Judul Artikel</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" required value="{{ old('title', $article->title) }}">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul</label>
                        @if($article->thumbnail)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="h-32 rounded shadow-sm">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-500" accept="image/*">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
                        <textarea name="content" rows="10" class="w-full border-gray-300 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" required>{{ old('content', $article->content) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Publikasi</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]">
                            <option value="published" {{ $article->status == 'published' ? 'selected' : '' }}>Terbitkan (Published)</option>
                            <option value="draft" {{ $article->status == 'draft' ? 'selected' : '' }}>Konsep (Draft)</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.articles.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg font-bold hover:bg-gray-300">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-[#83218F] text-white rounded-lg font-bold hover:bg-purple-800 shadow-md">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>