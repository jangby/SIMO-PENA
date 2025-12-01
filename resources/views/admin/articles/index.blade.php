<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Artikel & Berita
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                
                <div class="w-full md:w-1/3 relative">
                    <form action="{{ route('admin.articles.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari judul artikel..." 
                               class="w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-xl focus:ring-[#83218F] focus:border-[#83218F] text-sm bg-white shadow-sm transition">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>

                <a href="{{ route('admin.articles.create') }}" class="w-full md:w-auto bg-[#83218F] hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Tulis Artikel Baru
                </a>
            </div>

            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex justify-between items-center">
                    <span class="flex items-center gap-2 font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                
                @if($articles->isEmpty())
                    <div class="p-12 text-center text-gray-400">
                        <div class="w-16 h-16 bg-purple-50 text-[#83218F] rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Belum ada artikel yang ditulis.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-[#83218F] text-white uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4 rounded-tl-xl w-24">Cover</th>
                                    <th class="px-6 py-4">Judul Artikel</th>
                                    <th class="px-6 py-4">Penulis</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($articles as $article)
                                <tr class="hover:bg-purple-50 transition group">
                                    <td class="px-6 py-4">
                                        <div class="h-12 w-16 rounded-lg overflow-hidden bg-gray-200 shadow-sm relative border border-gray-200">
                                            @if($article->thumbnail)
                                                <img src="{{ asset('storage/' . $article->thumbnail) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-[9px] font-bold">NO IMG</div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-800 text-base mb-1 line-clamp-1 group-hover:text-[#83218F] transition">{{ $article->title }}</div>
                                        <div class="flex items-center gap-2 text-xs text-gray-400">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $article->created_at->format('d M Y') }}
                                            </span>
                                            <span>&bull;</span>
                                            <a href="{{ route('public.article.show', $article->slug) }}" target="_blank" class="text-blue-500 hover:underline flex items-center gap-1">
                                                Lihat <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center text-[#83218F] text-xs font-bold border border-purple-200">
                                                {{ substr($article->author->name, 0, 1) }}
                                            </div>
                                            <span class="text-sm text-gray-600 font-medium">{{ $article->author->name }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($article->status == 'published')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200 uppercase tracking-wide">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Terbit
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200 uppercase tracking-wide">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Draft
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-500 hover:text-white transition shadow-sm border border-yellow-100" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </a>
                                            
                                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="delete-form">
                                                @csrf @method('DELETE')
                                                <button type="button" class="btn-delete p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition shadow-sm border border-red-100" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 border-t border-gray-100 bg-gray-50 rounded-b-2xl">
                        {{ $articles->withQueryString()->links() }}
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus artikel ini?',
                    text: "Artikel yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: { popup: 'rounded-3xl' }
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });
    </script>
</x-admin-layout>