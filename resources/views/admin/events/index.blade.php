<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Kegiatan & Acara
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

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                
                <div class="w-full md:w-1/2 relative">
                    <form action="{{ route('admin.events.index') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama kegiatan..." 
                               class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-[#83218F] focus:border-[#83218F] text-sm bg-white shadow-sm transition hover:border-purple-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </div>

                <a href="{{ route('admin.events.create') }}" class="w-full md:w-auto bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg transform hover:-translate-y-1 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Kegiatan Baru
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-[#83218F] text-white uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4 rounded-tl-xl">Info Kegiatan</th>
                                <th class="px-6 py-4">Statistik</th>
                                <th class="px-6 py-4">Status Pendaftaran</th>
                                <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($events as $event)
                            <tr class="hover:bg-purple-50 transition duration-200 group">
                                
                                <td class="px-6 py-4">
                                    <div class="flex gap-4 items-start">
                                        <div class="flex-shrink-0 w-16 h-16 bg-gray-200 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                            @if($event->banner)
                                                <img src="{{ asset('storage/' . $event->banner) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-[#83218F] font-bold text-xs bg-purple-50">IPNU</div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 text-base mb-1 line-clamp-1 group-hover:text-[#83218F] transition">{{ $event->title }}</div>
                                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                                <span class="flex items-center gap-1 bg-gray-50 border border-gray-200 px-2 py-0.5 rounded">
                                                    <svg class="w-3 h-3 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ $event->start_time->format('d M Y') }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded font-bold uppercase text-[10px] {{ $event->type == 'makesta' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                                    {{ $event->type }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-2 bg-purple-100 text-[#83218F] rounded-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900 text-lg leading-none">{{ $event->registrations_count }}</div>
                                            <div class="text-[10px] text-gray-400 uppercase font-bold mt-0.5">Pendaftar</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.events.status', $event->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        
                                        @php
                                            $bgClass = match($event->status) {
                                                'open' => 'bg-green-100 text-green-700 ring-green-500/30',
                                                'closed' => 'bg-red-100 text-red-700 ring-red-500/30',
                                                'draft' => 'bg-gray-100 text-gray-700 ring-gray-500/30',
                                            };
                                        @endphp

                                        <div class="relative w-fit">
                                            <select name="status" onchange="this.form.submit()" 
                                                    class="appearance-none pl-3 pr-8 py-1.5 rounded-full text-xs font-bold uppercase border-0 cursor-pointer focus:ring-2 {{ $bgClass }} transition shadow-sm">
                                                <option value="open" {{ $event->status == 'open' ? 'selected' : '' }}>• Dibuka</option>
                                                <option value="closed" {{ $event->status == 'closed' ? 'selected' : '' }}>• Ditutup</option>
                                                <option value="draft" {{ $event->status == 'draft' ? 'selected' : '' }}>• Draft</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                            </div>
                                        </div>
                                    </form>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center items-center gap-2 opacity-80 group-hover:opacity-100 transition">
                                        
                                        <a href="{{ route('admin.events.manage', $event->id) }}" class="group/btn relative p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-100" title="Kelola">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        </a>

                                        <a href="{{ route('admin.events.edit', $event->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-500 hover:text-white transition shadow-sm border border-yellow-100" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm border border-red-100" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="bg-gray-100 p-4 rounded-full mb-3">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <p class="font-medium">Belum ada kegiatan ditemukan.</p>
                                        <a href="{{ route('admin.events.create') }}" class="text-[#83218F] text-xs font-bold mt-2 hover:underline">Buat kegiatan sekarang</a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-0 border-t border-gray-100 bg-gray-50 px-6 py-4 rounded-b-2xl">
                    {{ $events->withQueryString()->links() }}
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>