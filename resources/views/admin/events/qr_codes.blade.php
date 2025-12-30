<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                QR Code Peserta: {{ $event->title }}
            </h2>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Silakan download QR Code di bawah ini untuk ditempelkan pada desain ID Card masing-masing.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($participants as $participant)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center text-center hover:shadow-md transition">
                    
                    {{-- Preview QR Code (SVG agar ringan di browser) --}}
                    <div class="mb-4 p-2 bg-white border border-gray-200 rounded-lg">
                        {!! QrCode::size(120)->generate($participant->id) !!}
                    </div>

                    <h3 class="font-bold text-gray-900 line-clamp-1 w-full" title="{{ $participant->name }}">
                        {{ $participant->name }}
                    </h3>
                    
                    <p class="text-xs text-gray-500 mb-4 font-medium uppercase tracking-wide line-clamp-1 w-full" title="{{ $participant->school_origin }}">
                        {{ $participant->school_origin }}
                    </p>

                    <a href="{{ route('admin.events.qr.download', ['event' => $event->id, 'registration' => $participant->id]) }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 bg-[#83218F] border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:outline-none focus:border-purple-900 focus:ring ring-purple-300 disabled:opacity-25 transition ease-in-out duration-150 gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Download PNG
                    </a>
                </div>
                @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    Belum ada peserta yang statusnya disetujui.
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-admin-layout>