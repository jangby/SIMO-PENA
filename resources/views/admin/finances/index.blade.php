<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Keuangan
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ openModal: false, type: 'expense' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex justify-between items-center">
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pemasukan</p>
                    <h3 class="text-2xl font-black text-green-600 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengeluaran</p>
                    <h3 class="text-2xl font-black text-red-600 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-[#83218F] p-6 rounded-2xl shadow-lg text-white relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-purple-200 text-xs font-bold uppercase tracking-wider">Saldo Kas Saat Ini</p>
                        <h3 class="text-3xl font-black mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <div class="absolute -right-4 -bottom-4 opacity-20">
                         <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h3 class="font-bold text-lg text-gray-700">Riwayat Transaksi</h3>
                
                <div class="flex gap-2">
                    <button @click="openModal = true; type = 'income'" class="bg-green-50 text-green-600 hover:bg-green-100 px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 transition border border-green-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Catat Pemasukan
                    </button>
                    <button @click="openModal = true; type = 'expense'" class="bg-red-50 text-red-600 hover:bg-red-100 px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 transition border border-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                        Catat Pengeluaran
                    </button>

                    <a href="{{ route('admin.finances.export') }}" class="bg-[#83218F] text-white hover:bg-purple-800 px-4 py-2 rounded-xl font-bold text-xs flex items-center gap-2 shadow-md transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Excel
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-500">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Uraian Transaksi</th>
                                <th class="px-6 py-4 text-center">Jenis</th>
                                <th class="px-6 py-4 text-right">Nominal</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($finances as $finance)
                            <tr class="hover:bg-purple-50/30 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-600">
                                    {{ $finance->date->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-800 font-bold">{{ $finance->description }}</p>
                                    @if($finance->event)
                                        <span class="text-[10px] text-blue-500 bg-blue-50 px-2 py-0.5 rounded mt-1 inline-block font-bold uppercase">
                                            Event
                                        </span>
                                    @else
                                        <span class="text-[10px] text-gray-400 bg-gray-100 px-2 py-0.5 rounded mt-1 inline-block font-bold uppercase">
                                            Manual
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($finance->type == 'income')
                                        <span class="text-green-600 bg-green-100 px-2 py-1 rounded text-[10px] font-bold uppercase">Masuk</span>
                                    @else
                                        <span class="text-red-600 bg-red-100 px-2 py-1 rounded text-[10px] font-bold uppercase">Keluar</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="font-black {{ $finance->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $finance->type == 'income' ? '+' : '-' }} Rp {{ number_format($finance->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('admin.finances.destroy', $finance->id) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini? Saldo akan berubah.')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-400 hover:text-red-500 transition p-1" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-100">
                    {{ $finances->links() }}
                </div>
            </div>

        </div>

        <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm px-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all" @click.outside="openModal = false">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center" :class="type == 'income' ? 'bg-green-50' : 'bg-red-50'">
                    <h3 class="font-bold text-lg" :class="type == 'income' ? 'text-green-700' : 'text-red-700'">
                        Catat <span x-text="type == 'income' ? 'Pemasukan' : 'Pengeluaran'"></span>
                    </h3>
                    <button @click="openModal = false" class="text-gray-400 hover:text-gray-600">&times;</button>
                </div>

                <form action="{{ route('admin.finances.store') }}" method="POST" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="type" x-model="type">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Transaksi</label>
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nominal (Rp)</label>
                        <input type="number" name="amount" placeholder="0" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Keterangan / Uraian</label>
                        <textarea name="description" rows="3" class="w-full border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F]" placeholder="Contoh: Beli Kertas HVS / Sumbangan Alumni" required></textarea>
                    </div>

                    <button type="submit" class="w-full py-3 rounded-xl font-bold text-white shadow-lg transition transform active:scale-95"
                            :class="type == 'income' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'">
                        Simpan Transaksi
                    </button>
                </form>

            </div>
        </div>

    </div>
</x-admin-layout>