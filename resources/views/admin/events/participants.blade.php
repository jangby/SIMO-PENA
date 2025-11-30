<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data Peserta: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('admin.events.manage', $event->id) }}" class="mb-4 inline-block text-gray-600 hover:underline">&larr; Kembali ke Dashboard Kegiatan</a>
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="font-bold text-lg">Peserta Resmi ({{ $participants->count() }})</h3>
                        <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">Export Excel (Coming Soon)</button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Nama Lengkap</th>
                                    <th class="px-6 py-3">TTL</th>
                                    <th class="px-6 py-3">Asal Sekolah</th>
                                    <th class="px-6 py-3">No WA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participants as $index => $p)
                                <tr class="border-b">
                                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900">{{ $p->name }}</td>
                                    <td class="px-6 py-4">
                                        {{ $p->birth_place }}, {{ \Carbon\Carbon::parse($p->birth_date)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4">{{ $p->school_origin }}</td>
                                    <td class="px-6 py-4">
                                        <a href="https://wa.me/{{ $p->phone }}" target="_blank" class="text-green-600 hover:underline">{{ $p->phone }}</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>