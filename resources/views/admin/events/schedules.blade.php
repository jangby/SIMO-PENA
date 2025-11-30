<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rundown Acara
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-4">
                    <h3 class="font-bold text-lg mb-4 text-[#83218F]">Tambah Sesi</h3>
                    <form action="{{ route('admin.events.schedules.store', $event->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-xs font-bold text-gray-500">Mulai</label>
                                <input type="time" name="start_time" class="w-full border-gray-200 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-500">Selesai</label>
                                <input type="time" name="end_time" class="w-full border-gray-200 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500">Nama Kegiatan</label>
                            <input type="text" name="activity" class="w-full border-gray-200 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Pembukaan" required>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-gray-500">PIC / Petugas</label>
                            <input type="text" name="pic" class="w-full border-gray-200 rounded-lg focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Rekan Budi">
                        </div>
                        <button type="submit" class="w-full bg-[#83218F] text-white py-2.5 rounded-xl font-bold shadow-md hover:bg-purple-800 transition">
                            + Tambah Jadwal
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="mb-4 inline-block text-gray-500 hover:text-[#83218F] font-bold text-sm">&larr; Kembali</a>

                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    @if($schedules->isEmpty())
                        <div class="text-center py-10 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-2 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p>Belum ada rundown acara.</p>
                        </div>
                    @else
                        <div class="relative border-l-2 border-purple-100 ml-3 space-y-8 pb-4">                  
                            @foreach($schedules as $s)
                            <div class="relative pl-8 group">
                                <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full border-2 border-[#83218F] bg-white group-hover:bg-[#83218F] transition"></span>
                                
                                <div class="flex justify-between items-start">
                                    <div>
                                        <span class="text-xs font-bold text-[#83218F] bg-purple-50 px-2 py-0.5 rounded">
                                            {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                        </span>
                                        <h4 class="text-lg font-bold text-gray-800 mt-1">{{ $s->activity }}</h4>
                                        @if($s->pic)
                                            <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ $s->pic }}
                                            </p>
                                        @endif
                                    </div>
                                    
                                    <form action="{{ route('admin.events.schedules.destroy', [$event->id, $s->id]) }}" method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-300 hover:text-red-500 transition p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>