<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dokumentasi Kegiatan</h2>
            <a href="{{ route('admin.galleries.create') }}" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-2 px-4 rounded text-sm shadow-md transition">
                + Upload Foto Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">{{ session('success') }}</div>
            @endif

            @if($galleries->isEmpty())
                <div class="bg-white p-10 rounded-lg text-center border border-dashed border-gray-300">
                    <p class="text-gray-400">Belum ada dokumentasi diupload.</p>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($galleries as $gallery)
                    <div class="group relative bg-white rounded-lg shadow-sm overflow-hidden border border-gray-100">
                        <div class="h-40 overflow-hidden">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        </div>
                        
                        <div class="p-3">
                            <p class="text-xs font-bold text-gray-700 truncate">{{ $gallery->title }}</p>
                            <p class="text-[10px] text-gray-400">{{ $gallery->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Hapus foto ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded-full shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $galleries->links() }}
                </div>
            @endif

        </div>
    </div>
</x-admin-layout>