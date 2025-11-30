<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permohonan Pendaftaran Baru') }}
            </h2>
            <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                {{ $registrations->total() }} Pending
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Nama Pendaftar</th>
                                    <th class="px-6 py-3">Asal Sekolah</th>
                                    <th class="px-6 py-3">Acara Yang Dituju</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($registrations as $reg)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        {{ $reg->created_at->format('d M H:i') }}
                                        <br>
                                        <span class="text-xs text-gray-400">{{ $reg->created_at->diffForHumans() }}</span>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $reg->name }}
                                        <div class="text-xs font-normal text-gray-500">{{ $reg->phone }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $reg->school_origin }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($reg->event->type == 'makesta')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">MAKESTA</span>
                                        @elseif($reg->event->type == 'lakmud')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">LAKMUD</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">{{ strtoupper($reg->event->type) }}</span>
                                        @endif
                                        <div class="text-xs mt-1">{{ $reg->event->title }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.registrations.show', $reg->id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2">
                                            Periksa & Setujui
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            <p>Tidak ada permohonan pendaftaran baru saat ini.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $registrations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>