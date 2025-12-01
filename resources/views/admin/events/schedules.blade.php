<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Rundown Acara
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-6">
                    <div class="mb-6 border-b border-gray-100 pb-4">
                        <h3 class="font-bold text-lg text-[#83218F]">Tambah Sesi Baru</h3>
                        <p class="text-xs text-gray-400 mt-1">{{ $event->title }}</p>
                    </div>

                    <form action="{{ route('admin.events.schedules.store', $event->id) }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Tanggal Kegiatan</label>
                            <input type="date" name="schedule_date" 
                                   value="{{ old('schedule_date', $event->start_time->format('Y-m-d')) }}"
                                   min="{{ $event->start_time->format('Y-m-d') }}"
                                   class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Jam Mulai</label>
                                <input type="time" name="start_time" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Jam Selesai</label>
                                <input type="time" name="end_time" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">Nama Sesi / Materi</label>
                            <input type="text" name="activity" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Materi Aswaja" required>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1.5">PIC / Pemateri</label>
                            <input type="text" name="pic" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: KH. Fulan">
                        </div>

                        <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white py-3 rounded-xl font-bold shadow-lg transition transform active:scale-95 flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Simpan Jadwal
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-gray-800">Susunan Acara</h3>
                    <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm font-bold text-gray-500 hover:text-[#83218F]">&larr; Kembali</a>
                </div>

                @if($groupedSchedules->isEmpty())
                    <div class="bg-white p-12 rounded-3xl border border-dashed border-gray-200 text-center">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-300">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada rundown yang dibuat.</p>
                    </div>
                @else
                    <div class="space-y-8">
                        @foreach($groupedSchedules as $date => $schedules)
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="bg-purple-50 px-6 py-3 border-b border-purple-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#83218F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <h4 class="font-bold text-[#83218F] uppercase tracking-wide text-sm">
                                    {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
                                </h4>
                            </div>

                            <div class="p-6 space-y-0 relative">
                                <div class="absolute left-8 top-6 bottom-6 w-0.5 bg-gray-100"></div>

                                @foreach($schedules as $s)
                                <div class="relative pl-10 pb-6 last:pb-0 group">
                                    <div class="absolute left-0 top-1 w-4 h-4 rounded-full border-2 border-[#83218F] bg-white group-hover:bg-[#83218F] transition z-10"></div>

                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs font-bold text-gray-800 bg-gray-100 px-2 py-0.5 rounded">
                                                    {{ $s->start_time->format('H:i') }} - {{ $s->end_time->format('H:i') }}
                                                </span>
                                            </div>
                                            <h5 class="font-bold text-gray-900 text-base">{{ $s->activity }}</h5>
                                            @if($s->pic)
                                                <p class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    {{ $s->pic }}
                                                </p>
                                            @endif
                                        </div>

                                        <form action="{{ route('admin.events.schedules.destroy', [$event->id, $s->id]) }}" method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-admin-layout>