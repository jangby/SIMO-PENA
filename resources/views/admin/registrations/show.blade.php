<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Pendaftaran') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center mb-4 text-gray-500 hover:text-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Daftar
            </a>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase mb-2">Acara</h3>
                        <div class="font-bold text-lg text-green-800">{{ $registration->event->title }}</div>
                        <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">
                            {{ strtoupper($registration->event->type) }}
                        </span>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase mb-4">Biodata Peserta</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="text-xs text-gray-500">Nama Lengkap</label>
                                <p class="font-medium text-gray-900">{{ $registration->name }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Tanggal Lahir</label>
                                <p class="font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($registration->birth_date)->format('d M Y') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Nomor WhatsApp</label>
                                <p class="font-medium text-gray-900 flex items-center">
                                    {{ $registration->phone }}
                                    <a href="https://wa.me/{{ $registration->phone }}" target="_blank" class="ml-2 text-green-600 underline text-xs">Chat WA</a>
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Asal Sekolah</label>
                                <p class="font-medium text-gray-900">{{ $registration->school_origin }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Alamat</label>
                                <p class="font-medium text-gray-900">{{ $registration->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-blue-200">
                        <h3 class="text-sm font-bold text-blue-700 uppercase mb-4 flex items-center">
                            Bukti Pembayaran
                        </h3>
                        @if($registration->payment_proof)
                            <div class="bg-gray-100 p-2 rounded border text-center">
                                <img src="{{ asset('storage/' . $registration->payment_proof) }}" class="max-h-64 mx-auto rounded shadow-sm">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $registration->payment_proof) }}" target="_blank" class="text-blue-600 hover:underline text-sm">[Lihat Full]</a>
                                </div>
                            </div>
                        @else
                            <div class="text-red-500 text-sm">Tidak ada bukti pembayaran.</div>
                        @endif
                    </div>

                    @if($registration->certificate_file)
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-yellow-200">
                        <h3 class="text-sm font-bold text-yellow-700 uppercase mb-4">Bukti Sertifikat Makesta</h3>
                        <div class="bg-gray-100 p-2 rounded border text-center">
                            <img src="{{ asset('storage/' . $registration->certificate_file) }}" class="max-h-64 mx-auto rounded shadow-sm">
                            <div class="mt-2">
                                <a href="{{ asset('storage/' . $registration->certificate_file) }}" target="_blank" class="text-blue-600 hover:underline text-sm">[Lihat Full]</a>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500" x-data="{ openRejectModal: false }">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Keputusan Admin</h3>
                        <p class="text-sm text-gray-600 mb-6">
                            Pastikan data dan bukti pembayaran sudah valid sebelum menyetujui.
                        </p>

                        <div class="flex gap-4">
                            <button @click="openRejectModal = true" type="button" class="px-4 py-3 bg-red-100 text-red-700 rounded-lg font-bold hover:bg-red-200 transition flex-1 text-center border border-red-200">
                                ❌ Tolak
                            </button>

                            <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" class="flex-[2]">
                                @csrf
                                <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 shadow-md transition flex justify-center items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    SETUJUI & BUAT AKUN
                                </button>
                            </form>
                        </div>

                        <div x-show="openRejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 m-4 transform transition-all scale-100" @click.outside="openRejectModal = false">
                                <h3 class="text-lg font-bold text-red-600 mb-2">Tolak Pendaftaran?</h3>
                                <p class="text-sm text-gray-500 mb-4">Silakan masukkan alasan penolakan. Pesan ini akan dikirim ke WhatsApp pendaftar.</p>
                                
                                <form action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST">
                                    @csrf
                                    
                                    <textarea name="reason" rows="3" class="w-full border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500 text-sm mb-4" placeholder="Contoh: Bukti pembayaran buram / Data tidak sesuai..." required></textarea>
                                    
                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="openRejectModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-bold hover:bg-gray-200 text-sm">Batal</button>
                                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg font-bold hover:bg-red-700 text-sm shadow-lg">Kirim Penolakan</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>