<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Galeri Dokumentasi
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.galleries.create') }}" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Upload Foto Baru
                </a>
            </div>

            @if($galleries->isEmpty())
                <div class="bg-white p-16 rounded-3xl shadow-sm text-center border-2 border-dashed border-gray-300 flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-purple-50 text-[#83218F] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Galeri Masih Kosong</h3>
                    <p class="text-gray-500 text-sm mt-1 mb-6">Belum ada dokumentasi kegiatan yang diupload.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="text-[#83218F] font-bold text-sm hover:underline">Upload Sekarang &rarr;</a>
                </div>
            @else
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($galleries as $gallery)
                    <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100">
                        
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100 relative">
                            <img src="{{ asset('storage/' . $gallery->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                            
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center gap-3 backdrop-blur-sm">
                                
                                <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="delete-form">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn-delete bg-white text-red-500 p-3 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition transform hover:scale-110" title="Hapus Foto">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>

                                <a href="{{ asset('storage/' . $gallery->image) }}" target="_blank" class="bg-white text-blue-500 p-3 rounded-full shadow-lg hover:bg-blue-500 hover:text-white transition transform hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                            </div>
                        </div>
                        
                        <div class="p-4 relative bg-white">
                            <h3 class="font-bold text-gray-800 text-sm truncate" title="{{ $gallery->title }}">{{ $gallery->title }}</h3>
                            <div class="flex items-center justify-between mt-2">
                                <p class="text-[10px] text-gray-400 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $gallery->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $galleries->links() }}
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Notifikasi Flash
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#f0fdf4', 
                color: '#166534'
            });
        @elseif(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        @endif

        // Konfirmasi Hapus
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Hapus foto ini?',
                    text: "Tindakan ini tidak dapat dibatalkan!",
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