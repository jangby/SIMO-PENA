<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Akun Panitia
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex justify-between items-center">
                    <span class="flex items-center gap-2 font-bold text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            {{-- TOMBOL DIPINDAHKAN KE SINI (DI ATAS TABEL) --}}
            <div class="flex justify-end mb-6">
                <a href="{{ route('admin.panitia.create') }}" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Panitia
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-[#83218F] text-white uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-xl">Nama Panitia</th>
                                <th class="px-6 py-4">Email Login</th>
                                <th class="px-6 py-4">Tanggal Dibuat</th>
                                <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($panitias as $panitia)
                            <tr class="hover:bg-purple-50 transition duration-200">
                                <td class="px-6 py-4 font-bold text-gray-900">{{ $panitia->name }}</td>
                                <td class="px-6 py-4">{{ $panitia->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-gray-100 text-gray-600 py-1 px-3 rounded-full text-xs font-bold">
                                        {{ $panitia->created_at->format('d M Y') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.panitia.destroy', $panitia->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun panitia ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-white hover:bg-red-600 border border-red-200 px-3 py-2 rounded-lg text-xs font-bold transition flex items-center gap-1 mx-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        <p>Belum ada akun panitia dibuat.</p>
                                    </div>
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