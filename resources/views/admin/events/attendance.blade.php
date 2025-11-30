<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Absensi: {{ $event->title }}
        </h2>
    </x-slot>

    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="text-gray-600 hover:text-[#83218F] font-bold text-sm">
                    &larr; Kembali ke Dashboard
                </a>
                
                <button onclick="startScanner()" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl shadow-lg flex items-center gap-2 transition transform active:scale-95">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Buka Kamera Scanner
                </button>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-gray-300">
                    <span class="text-gray-500 text-xs font-bold uppercase">Total Peserta</span>
                    <div class="text-2xl font-bold">{{ $participants->count() }}</div>
                </div>
                <div class="bg-white p-4 rounded-xl shadow-sm border-l-4 border-[#83218F]">
                    <span class="text-[#83218F] text-xs font-bold uppercase">Sudah Hadir</span>
                    <div class="text-2xl font-bold text-purple-900">
                        {{ $participants->whereNotNull('presence_at')->count() }}
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6">
                    <div class="mb-4">
                        <input type="text" id="searchName" placeholder="Cari nama peserta manual..." class="w-full md:w-1/3 border-gray-300 rounded-lg focus:ring-[#83218F] focus:border-[#83218F] text-sm">
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-purple-50 text-[#83218F] uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-3 rounded-l-lg">Nama Peserta</th>
                                    <th class="px-6 py-3">Waktu Hadir</th>
                                    <th class="px-6 py-3 text-center rounded-r-lg">Aksi Manual</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceTable">
                                @foreach($participants as $p)
                                <tr class="border-b hover:bg-gray-50 search-item" id="row-{{ $p->id }}">
                                    <td class="px-6 py-4 font-bold text-gray-900">
                                        {{ $p->name }}
                                        <div class="text-xs text-gray-400 font-normal">{{ $p->school_origin }}</div>
                                    </td>
                                    <td class="px-6 py-4 status-col">
                                        @if($p->presence_at)
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full">
                                                {{ \Carbon\Carbon::parse($p->presence_at)->format('H:i') }} WIB
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-xs px-2.5 py-0.5 rounded-full">Belum Hadir</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center action-col">
                                        @if(!$p->presence_at)
                                            <form action="{{ route('admin.events.attendance.checkin', [$event->id, $p->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-blue-50 text-blue-600 hover:bg-blue-100 font-bold py-1 px-3 rounded text-xs transition">
                                                    Check In
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.events.attendance.cancel', [$event->id, $p->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs underline">
                                                    Batal
                                                </button>
                                            </form>
                                        @endif
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

    <div id="scannerModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm items-center justify-center">
        <div class="bg-white w-full max-w-md rounded-3xl overflow-hidden shadow-2xl relative m-4">
            
            <div class="bg-[#83218F] p-4 flex justify-between items-center text-white">
                <h3 class="font-bold text-lg">Scan QR Code Peserta</h3>
                <button onclick="stopScanner()" class="bg-white/20 hover:bg-white/40 rounded-full p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-4 bg-black relative">
                <div id="reader" class="w-full rounded-xl overflow-hidden"></div>
                <p class="text-center text-gray-400 text-xs mt-2">Arahkan kamera ke QR Code di HP Peserta</p>
            </div>

            <div id="scanResult" class="p-4 bg-gray-50 min-h-[100px] flex items-center justify-center text-center">
                <p class="text-gray-500 text-sm">Menunggu scan...</p>
            </div>
        </div>
    </div>

    <audio id="beepSound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3"></audio>

    <script>
        // 1. Search Manual Logic
        document.getElementById('searchName').addEventListener('keyup', function() {
            let value = this.value.toLowerCase();
            let rows = document.querySelectorAll('.search-item');
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        // 2. Logic Scanner
        let html5QrcodeScanner;
        const modal = document.getElementById('scannerModal');
        const resultDiv = document.getElementById('scanResult');
        const beep = document.getElementById('beepSound');

        function startScanner() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            html5QrcodeScanner = new Html5Qrcode("reader");
            
            // Config kamera
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            // Start kamera (Environment = Kamera Belakang)
            html5QrcodeScanner.start({ facingMode: "environment" }, config, onScanSuccess, onScanFailure);
        }

        function stopScanner() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.stop().then(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    resultDiv.innerHTML = '<p class="text-gray-500 text-sm">Menunggu scan...</p>';
                }).catch(err => console.error(err));
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Logic saat QR Terdeteksi
        function onScanSuccess(decodedText, decodedResult) {
            // Pause sebentar biar gak scan berkali-kali
            html5QrcodeScanner.pause();

            // Bunyikan Beep
            beep.play();

            // Tampilkan Loading
            resultDiv.innerHTML = '<span class="text-blue-600 font-bold animate-pulse">Memproses data...</span>';

            // Kirim ke Server via AJAX (Fetch)
            fetch("{{ route('admin.events.attendance.scan', $event->id) }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ registration_id: decodedText })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Tampilkan Sukses Hijau
                    resultDiv.innerHTML = `
                        <div class="bg-green-100 text-green-800 p-3 rounded-lg w-full">
                            <h4 class="font-bold text-lg">✅ BERHASIL!</h4>
                            <p class="font-bold">${data.user_name}</p>
                            <p class="text-xs">Waktu: ${data.time}</p>
                        </div>
                    `;
                    
                    // Update Tabel di belakang (DOM Manipulation)
                    updateTableStatus(decodedText, data.time);

                } else if (data.status === 'warning') {
                    // Warning Kuning (Sudah absen)
                    resultDiv.innerHTML = `
                        <div class="bg-yellow-100 text-yellow-800 p-3 rounded-lg w-full">
                            <h4 class="font-bold">⚠️ PERINGATAN</h4>
                            <p>${data.message}</p>
                        </div>
                    `;
                } else {
                    // Error Merah
                    resultDiv.innerHTML = `
                        <div class="bg-red-100 text-red-800 p-3 rounded-lg w-full">
                            <h4 class="font-bold">❌ GAGAL</h4>
                            <p>${data.message}</p>
                        </div>
                    `;
                }

                // Resume scanning setelah 2 detik
                setTimeout(() => {
                    resultDiv.innerHTML = '<p class="text-gray-500 text-sm">Siap scan berikutnya...</p>';
                    html5QrcodeScanner.resume();
                }, 2500);
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = '<span class="text-red-500">Terjadi kesalahan sistem.</span>';
                html5QrcodeScanner.resume();
            });
        }

        function onScanFailure(error) {
            // Biarkan saja, ini terpanggil tiap frame jika tidak ada QR
        }

        // Helper update tabel tanpa reload
        function updateTableStatus(id, time) {
            const row = document.getElementById('row-' + id);
            if(row) {
                // Ubah kolom status
                const statusCol = row.querySelector('.status-col');
                statusCol.innerHTML = `<span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded-full">${time} WIB</span>`;
                
                // Hilangkan tombol checkin manual
                const actionCol = row.querySelector('.action-col');
                actionCol.innerHTML = `<span class="text-gray-400 text-xs">Verified by Scan</span>`;
                
                // Highlight baris
                row.classList.add('bg-green-50');
            }
        }
    </script>
</x-admin-layout>