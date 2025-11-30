<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Kegiatan') }}
            </h2>
            <a href="{{ route('admin.events.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Buat Kegiatan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Nama Kegiatan</th>
                                <th class="px-6 py-3">Waktu</th>
                                <th class="px-6 py-3">Tipe</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($events as $event)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4 font-bold text-gray-900">
                                    {{ $event->title }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $event->start_time->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">
                                        {{ strtoupper($event->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.events.status', $event->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        
                                        @php
                                            $colorClass = match($event->status) {
                                                'open' => 'bg-green-100 text-green-800 border-green-200',
                                                'closed' => 'bg-red-100 text-red-800 border-red-200',
                                                'draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            };
                                        @endphp

                                        <select name="status" onchange="this.form.submit()" 
                                                class="text-xs font-bold uppercase rounded-lg border-0 py-1 pl-2 pr-8 cursor-pointer focus:ring-2 focus:ring-[#83218F] {{ $colorClass }}">
                                            <option value="open" {{ $event->status == 'open' ? 'selected' : '' }}>DIBUKA</option>
                                            <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>DITUTUP</option>
                                            <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>DRAFT</option>
                                        </select>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-center">
    <div class="flex justify-center items-center space-x-2">
        
        <a href="{{ route('admin.events.manage', $event->id) }}" class="flex items-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-3 py-2 rounded" title="Kelola Kegiatan">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Kelola
        </a>

        <a href="{{ route('admin.events.edit', $event->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 p-2 rounded" title="Edit Info">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
        </a>

        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini beserta seluruh data pesertanya?')">
            @csrf @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white p-2 rounded" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
        </form>

    </div>
</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-6">Belum ada kegiatan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $events->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>