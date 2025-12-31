<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Peserta: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
            <div class="mb-4 flex items-center bg-green-50 border-l-4 border-green-500 p-4 shadow-sm rounded-r" role="alert">
                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
            @endif
            @if(session('error'))
            <div class="mb-4 flex items-center bg-red-50 border-l-4 border-red-500 p-4 shadow-sm rounded-r" role="alert">
                <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
            @endif

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-[#83218F] font-bold text-sm transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>

                <div class="flex flex-wrap gap-2">
                    <button onclick="openModal()" class="flex items-center gap-2 bg-[#83218F] text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-purple-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        + Daftar Offline
                    </button>

                    <a href="{{ route('admin.events.participants.export', $event->id) }}" class="flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-green-700 shadow-md transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4-4m4 4V4"></path></svg>
                        Excel
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h3 class="font-bold text-lg text-gray-800 border-l-4 border-[#83218F] pl-3">
                            Data Peserta Terdaftar
                            <span class="text-xs font-normal text-white bg-[#83218F] px-2 py-0.5 rounded-full ml-2">{{ $participants->count() }}</span>
                        </h3>
                        <div class="relative w-full md:w-64">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" id="search" placeholder="Cari nama atau sekolah..." class="w-full pl-10 pr-4 py-2 border-gray-200 rounded-xl text-sm focus:ring-[#83218F] focus:border-[#83218F] transition-shadow">
                        </div>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-gray-100">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Nama Lengkap</th>
                                    <th class="px-6 py-4">Asal Sekolah</th>
                                    <th class="px-6 py-4">L/P</th>
                                    <th class="px-6 py-4">Kontak</th>
                                    <th class="px-6 py-4 text-center">Kehadiran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white" id="tableBody">
                                @forelse($participants as $p)
                                <tr class="hover:bg-purple-50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">{{ $p->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $p->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-medium">{{ $p->school_origin }}</td>
                                    <td class="px-6 py-4">
                                        @if($p->gender == 'L')
                                            <span class="text-blue-600 font-bold bg-blue-50 px-2 py-1 rounded">L</span>
                                        @else
                                            <span class="text-pink-600 font-bold bg-pink-50 px-2 py-1 rounded">P</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="https://wa.me/{{ $p->phone }}" target="_blank" class="inline-flex items-center gap-1 text-green-600 font-bold hover:text-green-700">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654z"/></svg>
                                            {{ $p->phone }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($p->presence_at)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                HADIR
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                BELUM
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                        Belum ada peserta yang terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="manualModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity blur-sm" aria-hidden="true" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                
                <div class="bg-[#83218F] px-6 py-4 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white" id="modal-title">
                        Form Pendaftaran Offline / Manual
                    </h3>
                    <button type="button" onclick="closeModal()" class="text-purple-200 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('admin.events.participants.store', $event->id) }}" method="POST">
                    @csrf
                    <div class="px-6 py-6 bg-white">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b pb-1">Informasi Akun & Kontak</h4>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                    <input type="text" name="name" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="Contoh: Ahmad Fauzi">
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif</label>
                                    <input type="email" name="email" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="email@contoh.com">
                                    <p class="text-xs text-gray-400 mt-1">Digunakan untuk login sistem.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">No WhatsApp</label>
                                    <input type="number" name="phone" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="08xxxxxxx">
                                    <p class="text-xs text-gray-400 mt-1">Password dikirim ke nomor ini.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Domisili Lengkap</label>
                                    <textarea name="address" rows="3" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="Jalan, RT/RW, Desa, Kecamatan..."></textarea>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b pb-1">Biodata Peserta</h4>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Kelamin</label>
                                    <select name="gender" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm">
                                        <option value="" disabled selected>- Pilih -</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tempat Lahir</label>
                                        <input type="text" name="birth_place" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="Kota">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tgl Lahir</label>
                                        <input type="date" name="birth_date" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Asal Sekolah / Instansi</label>
                                    <input type="text" name="school_origin" required class="w-full rounded-lg border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20 transition shadow-sm" placeholder="Nama Sekolah / Kampus">
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-2 rounded-b-2xl">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-2 bg-[#83218F] text-base font-bold text-white hover:bg-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition">
                            Simpan Data
                        </button>
                        <button type="button" onclick="closeModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-6 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Search Filter
        document.getElementById('search').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        // Modal Logic
        function openModal() {
            document.getElementById('manualModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('manualModal').classList.add('hidden');
        }
    </script>
</x-admin-layout>