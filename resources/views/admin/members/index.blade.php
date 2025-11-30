<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Anggota IPNU') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg">Daftar Kader</h3>
                        <span class="text-sm text-gray-500">Total: {{ $members->total() }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Nama</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Bergabung</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $member->name }}
                                        @if(!$member->profile)
                                            <span class="text-xs text-red-500 ml-1">(Belum Lengkap)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $member->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $member->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.members.show', $member->id) }}" class="font-medium text-blue-600 hover:underline">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                                
                                @if($members->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                        Belum ada anggota yang mendaftar.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $members->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>