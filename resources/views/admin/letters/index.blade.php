<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">E-Arsip Surat</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex justify-between items-center">
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                    <button @click="show = false">&times;</button>
                </div>
            @endif

            <div class="flex space-x-2 mb-6 bg-white p-1 rounded-xl w-fit shadow-sm border border-gray-100">
                <a href="{{ route('admin.letters.index', ['type' => 'incoming']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-bold transition {{ $type == 'incoming' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   📥 Surat Masuk
                </a>
                <a href="{{ route('admin.letters.index', ['type' => 'outgoing']) }}" 
                   class="px-6 py-2 rounded-lg text-sm font-bold transition {{ $type == 'outgoing' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   📤 Surat Keluar
                </a>
            </div>

            <div class="flex justify-end mb-4">
                <a href="{{ route('admin.letters.create', ['type' => $type]) }}" class="bg-white border border-[#83218F] text-[#83218F] hover:bg-[#83218F] hover:text-white px-4 py-2 rounded-xl font-bold text-sm transition shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Catat {{ $type == 'incoming' ? 'Surat Masuk' : 'Surat Keluar' }}
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-6 py-4">Nomor & Tanggal</th>
                            <th class="px-6 py-4">Perihal</th>
                            <th class="px-6 py-4">{{ $type == 'incoming' ? 'Pengirim' : 'Tujuan' }}</th>
                            <th class="px-6 py-4 text-center">File</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($letters as $letter)
                        <tr class="hover:bg-purple-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $letter->reference_number }}</div>
                                <div class="text-xs text-gray-400">{{ $letter->letter_date->format('d F Y') }}</div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">
                                {{ $letter->subject }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $type == 'incoming' ? $letter->sender : $letter->recipient }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($letter->file_path)
                                    <a href="{{ asset('storage/' . $letter->file_path) }}" target="_blank" class="text-blue-500 hover:underline text-xs font-bold">Lihat PDF/Foto</a>
                                @else
                                    <span class="text-gray-300 text-xs">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.letters.destroy', $letter->id) }}" method="POST" onsubmit="return confirm('Hapus arsip ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-400 text-sm">Belum ada arsip surat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $letters->appends(['type' => $type])->links() }}
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>