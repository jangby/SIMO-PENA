<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Artikel</h2>
            <a href="{{ route('admin.articles.create') }}" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-2 px-4 rounded text-sm shadow-md transition">
                + Tulis Artikel
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-purple-50 text-[#83218F] uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-3">Thumbnail</th>
                                    <th class="px-6 py-3">Judul</th>
                                    <th class="px-6 py-3">Penulis</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($articles as $article)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        @if($article->thumbnail)
                                            <img src="{{ asset('storage/' . $article->thumbnail) }}" class="h-12 w-20 object-cover rounded shadow-sm">
                                        @else
                                            <div class="h-12 w-20 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Image</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900 w-1/3">
                                        {{ Str::limit($article->title, 50) }}
                                        <div class="text-xs text-gray-400 font-normal mt-1">{{ $article->created_at->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $article->author->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $article->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-600' }}">
                                            {{ ucfirst($article->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold text-xs bg-yellow-100 px-2 py-1 rounded">Edit</a>
                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold text-xs bg-red-100 px-2 py-1 rounded">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-6 text-gray-400">Belum ada artikel.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $articles->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>