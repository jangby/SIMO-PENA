<x-mobile-layout>
    <x-slot name="title">Scanner</x-slot>

    {{-- HEADER INFO EVENT --}}
    <div class="mb-4 text-center">
        <h2 class="font-bold text-gray-800 text-sm">{{ $event->title }}</h2>
        <p class="text-[10px] text-gray-500">{{ $event->location }}</p>
    </div>

    {{-- PILIH SESI ABSENSI --}}
    <div class="bg-white p-4 rounded-[2rem] shadow-sm mb-6 border border-gray-100 relative z-20">
        <label class="text-xs font-bold text-[#83218F] uppercase ml-1 mb-2 block">
            Pilih Sesi Absensi
        </label>
        
        <select id="scan-mode" class="w-full border-gray-200 bg-gray-50 rounded-xl text-sm font-bold text-gray-800 focus:ring-[#83218F] focus:border-[#83218F] py-3">
            
            {{-- Opsi 1: Absensi Masuk --}}
            <option value="checkin" class="font-bold text-green-600">
                🟢 DAFTAR ULANG (Check-In Awal)
            </option>
            
            <hr>

            {{-- Opsi 2: Loop Rundown Acara --}}
            <optgroup label="Sesuai Rundown Acara">
                @foreach($event->schedules as $schedule)
                    {{-- PERBAIKAN: Menggunakan 'activity' sesuai database --}}
                    <option value="{{ $schedule->id }}">
                        📘 {{ $schedule->activity }}
                    </option>
                @endforeach
            </optgroup>

        </select>
        <p class="text-[10px] text-gray-400 mt-2 ml-1">
            *Pastikan memilih sesi yang benar sebelum scan.
        </p>
    </div>

    {{-- AREA KAMERA --}}
    <div class="relative overflow-hidden rounded-[2.5rem] shadow-2xl bg-black aspect-square mb-6 border-[4px] border-white">
        <div id="reader" class="w-full h-full object-cover"></div>
        
        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
            <div class="w-64 h-64 border-2 border-white/30 rounded-3xl relative">
                <div class="absolute top-0 left-0 w-6 h-6 border-t-4 border-l-4 border-[#83218F] rounded-tl-xl"></div>
                <div class="absolute top-0 right-0 w-6 h-6 border-t-4 border-r-4 border-[#83218F] rounded-tr-xl"></div>
                <div class="absolute bottom-0 left-0 w-6 h-6 border-b-4 border-l-4 border-[#83218F] rounded-bl-xl"></div>
                <div class="absolute bottom-0 right-0 w-6 h-6 border-b-4 border-r-4 border-[#83218F] rounded-br-xl"></div>
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#83218F] to-transparent animate-scan shadow-[0_0_15px_rgba(131,33,143,0.8)]"></div>
            </div>
        </div>
    </div>

    {{-- HASIL SCAN (Pop Up) --}}
    <div id="result-area" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4 bg-black/50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-3xl shadow-2xl text-center w-full max-w-sm transform transition-all scale-100">
            
            <div id="scan-loading" class="hidden py-4">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#83218F] mx-auto"></div>
                <p class="text-xs text-gray-500 mt-3 font-bold">Memverifikasi Data...</p>
            </div>

            <div id="scan-success" class="hidden">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 animate-bounce">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="font-black text-xl text-gray-800 mb-1" id="participant-name">Nama Peserta</h3>
                <p class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-4" id="participant-info">Asal Sekolah</p>
                <div class="bg-green-50 text-green-700 px-3 py-2 rounded-xl text-xs font-bold inline-block" id="scan-type">
                    Berhasil Absen
                </div>
                <button onclick="closeResult()" class="mt-6 w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-bold hover:bg-gray-200">
                    Scan Berikutnya
                </button>
            </div>

            <div id="scan-error" class="hidden">
                 <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <h3 class="font-bold text-lg text-gray-800 mb-1">Gagal!</h3>
                <p class="text-sm text-red-500 px-4" id="error-message">Data tidak ditemukan</p>
                <button onclick="closeResult()" class="mt-6 w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold">
                    Coba Lagi
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        let isProcessing = false;
        const resultArea = document.getElementById('result-area');

        function closeResult() {
            resultArea.classList.add('hidden');
            setTimeout(() => { isProcessing = false; }, 500);
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;
            
            let mode = document.getElementById('scan-mode').value;

            // UI Loading
            resultArea.classList.remove('hidden');
            document.getElementById('scan-loading').classList.remove('hidden');
            document.getElementById('scan-success').classList.add('hidden');
            document.getElementById('scan-error').classList.add('hidden');

            // Kirim ke Backend
            axios.post('{{ route("panitia.scan.process") }}', {
                qrcode: decodedText,
                mode: mode,
                event_id: '{{ $event->id }}'
            })
            .then(function (response) {
                document.getElementById('scan-loading').classList.add('hidden');
                document.getElementById('scan-success').classList.remove('hidden');
                
                document.getElementById('participant-name').innerText = response.data.name;
                document.getElementById('participant-info').innerText = response.data.school;
                
                let typeText = response.data.type === 'Daftar Ulang' ? '✔ Terdaftar Ulang' : '✔ Hadir di Sesi Ini';
                document.getElementById('scan-type').innerText = typeText;
            })
            .catch(function (error) {
                document.getElementById('scan-loading').classList.add('hidden');
                document.getElementById('scan-error').classList.remove('hidden');
                
                let msg = error.response && error.response.data ? error.response.data.message : 'QR Code tidak valid';
                document.getElementById('error-message').innerText = msg;
            });
        }

        // --- UPDATE PENTING DI SINI ---
        // Kita tambahkan catch() untuk menampilkan pesan error jika kamera gagal
        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

        // Coba buka kamera belakang (environment)
        html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess)
        .catch(err => {
            console.error("Error kamera belakang:", err);
            
            // Jika gagal (misal di laptop gak ada kamera belakang), coba kamera depan (user)
            html5QrCode.start({ facingMode: "user" }, config, onScanSuccess)
            .catch(err2 => {
                // Jika masih gagal, tampilkan Alert Error
                alert("GAGAL MEMBUKA KAMERA:\n" + err2 + "\n\nPastikan akses menggunakan HTTPS atau Localhost, dan izinkan akses kamera.");
            });
        });
    </script>
    
    <style>
        @keyframes scan { 0% {top: 0%} 50% {top: 98%} 100% {top: 0%} }
        .animate-scan { animation: scan 2s infinite ease-in-out; }
    </style>
</x-mobile-layout>