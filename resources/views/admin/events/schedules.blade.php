<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rundown Acara: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <div class="md:col-span-1">
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <h3 class="font-bold text-lg mb-4">Tambah Sesi</h3>
                    <form action="{{ route('admin.events.schedules.store', $event->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium">Jam Mulai</label>
                            <input type="time" name="start_time" class="w-full border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Jam Selesai</label>
                            <input type="time" name="end_time" class="w-full border-gray-300 rounded-md" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Kegiatan / Materi</label>
                            <input type="text" name="activity" class="w-full border-gray-300 rounded-md" placeholder="Contoh: Pembukaan" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">PIC / Pemateri (Opsional)</label>
                            <input type="text" name="pic" class="w-full border-gray-300 rounded-md" placeholder="Contoh: Rekan Budi">
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md font-bold hover:bg-blue-700">
                            + Tambah ke Rundown
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="mb-4 inline-block text-gray-600 hover:underline">&larr; Kembali ke Dashboard</a>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @if($schedules->isEmpty())
                            <p class="text-center text-gray-400 py-10">Belum ada jadwal dibuat.</p>
                        @else
                            <div class="relative border-l border-gray-200 ml-4">                  
                                @foreach($schedules as $s)
                                <li class="mb-10 ml-6 list-none">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                                        <svg class="w-3 h-3 text-blue-800" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                                    </span>
                                    <div class="flex justify-between items-start p-4 bg-white border rounded-lg shadow-sm hover:bg-gray-50">
                                        <div>
                                            <time class="mb-1 text-sm font-normal text-gray-400">
                                                {{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}
                                            </time>
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $s->activity }}</h3>
                                            @if($s->pic)
                                                <p class="text-base font-normal text-gray-500">PIC: {{ $s->pic }}</p>
                                            @endif
                                        </div>
                                        <form action="{{ route('admin.events.schedules.destroy', [$event->id, $s->id]) }}" method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="text-red-500 hover:text-red-700 text-xs">Hapus</button>
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>