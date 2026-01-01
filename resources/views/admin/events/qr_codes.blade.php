<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            QR Codes Peserta: {{ $event->title }}
        </h2>
    </x-slot>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #printableArea, #printableArea * {
                visibility: visible;
            }
            #printableArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-inside: avoid;
            }
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 no-print">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#83218F] font-bold text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>

                <div class="flex flex-wrap items-center gap-3">
                    <form action="{{ route('admin.events.qr.codes', $event->id) }}" method="GET" class="flex items-center">
                        <select name="gender" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-xl focus:ring-[#83218F] focus:border-[#83218F] shadow-sm py-2 px-4">
                            <option value="">- Semua Peserta -</option>
                            <option value="L" {{ request('gender') == 'L' ? 'selected' : '' }}>IPNU (Laki-laki)</option>
                            <option value="P" {{ request('gender') == 'P' ? 'selected' : '' }}>IPPNU (Perempuan)</option>
                        </select>
                    </form>

                    <button onclick="window.print()" class="flex items-center gap-2 bg-gray-800 text-white px-5 py-2 rounded-xl font-bold text-sm hover:bg-gray-900 shadow-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak Halaman
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6" id="printableArea">
                
                <div class="mb-6 border-b pb-4 flex justify-between items-center">
                    <h3 class="font-bold text-lg text-gray-800">
                        Daftar QR Code Peserta
                        @if(request('gender') == 'L') <span class="text-[#83218F]">(IPNU)</span> @endif
                        @if(request('gender') == 'P') <span class="text-[#83218F]">(IPPNU)</span> @endif
                    </h3>
                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">Total: {{ $participants->count() }}</span>
                </div>

                @if($participants->isEmpty())
                    <div class="text-center py-10 text-gray-400">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <p>Tidak ada data peserta untuk kategori ini.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($participants as $p)
                        <div class="page-break flex items-center bg-gray-50 border border-gray-200 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                            <div class="bg-white p-2 rounded-lg border border-gray-100 flex-shrink-0">
                                {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($p->id) !!}
                            </div>
                            
                            <div class="ml-4 overflow-hidden">
                                <h4 class="font-bold text-gray-900 truncate" title="{{ $p->name }}">{{ $p->name }}</h4>
                                <p class="text-xs text-gray-500 mb-1 truncate">{{ $p->school_origin }}</p>
                                
                                <div class="flex items-center gap-2 mt-2">
                                    @if($p->gender == 'L')
                                        <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-0.5 rounded">IPNU</span>
                                    @else
                                        <span class="text-[10px] font-bold bg-pink-100 text-pink-700 px-2 py-0.5 rounded">IPPNU</span>
                                    @endif

                                    <a href="{{ route('admin.events.qr.download', [$event->id, $p->id]) }}" class="no-print text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded hover:bg-green-200 transition flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4-4m4 4V4"></path></svg>
                                        Save
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-admin-layout>