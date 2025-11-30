<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Kegiatan Baru</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium">Nama Kegiatan</label>
                        <input type="text" name="title" class="w-full border-gray-300 rounded-lg" required placeholder="Contoh: MAKESTA RAYA ZONA 1">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Jenis Kegiatan</label>
                            <select name="type" class="w-full border-gray-300 rounded-lg">
                                <option value="makesta">MAKESTA</option>
                                <option value="lakmud">LAKMUD</option>
                                <option value="rapat">RAPAT</option>
                                <option value="lainnya">LAINNYA</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Biaya (0 jika gratis)</label>
                            <input type="number" name="price" class="w-full border-gray-300 rounded-lg" value="0">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium">Waktu Mulai</label>
                            <input type="datetime-local" name="start_time" class="w-full border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Waktu Selesai</label>
                            <input type="datetime-local" name="end_time" class="w-full border-gray-300 rounded-lg" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Lokasi Kegiatan</label>
                        <input type="text" name="location" class="w-full border-gray-300 rounded-lg" required placeholder="Contoh: Gedung MWC NU Limbangan">
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Deskripsi Lengkap</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg" required placeholder="Jelaskan detail acara..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Banner / Poster</label>
                        <input type="file" name="banner" class="w-full border border-gray-300 rounded-lg p-2" accept="image/*">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded-lg font-bold hover:bg-green-800">
                            PUBLIKASIKAN KEGIATAN
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>