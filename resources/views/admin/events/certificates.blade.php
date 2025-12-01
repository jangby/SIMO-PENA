<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Upload Sertifikat: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="text-gray-500 hover:text-[#83218F] font-bold text-sm">
                    &larr; Kembali ke Dashboard
                </a>
                <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">
                    {{ $participants->count() }} Peserta Hadir
                </span>
            </div>
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-3">Nama Peserta</th>
                                <th class="px-6 py-3">Instansi</th>
                                <th class="px-6 py-3 text-center">Status File</th>
                                <th class="px-6 py-3 text-center">Aksi Upload</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($participants as $p)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $p->name }}</td>
                                <td class="px-6 py-4">{{ $p->school_origin }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if($p->certificate_file)
                                        <a href="{{ asset('storage/' . $p->certificate_file) }}" target="_blank" class="inline-flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded hover:bg-blue-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-xs text-red-400 font-bold">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.events.certificates.store', [$event->id, $p->id]) }}" method="POST" enctype="multipart/form-data" class="flex items-center justify-center gap-2">
                                        @csrf
                                        <div class="relative w-32">
                                            <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="this.form.submit()" required>
                                            <button type="button" class="w-full bg-gray-100 text-gray-600 hover:bg-[#83218F] hover:text-white font-bold py-1.5 px-3 rounded-lg text-xs transition border border-gray-300">
                                                {{ $p->certificate_file ? 'Ganti File' : 'Pilih File' }}
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400">
                                    Belum ada peserta yang melakukan absensi (hadir).
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>