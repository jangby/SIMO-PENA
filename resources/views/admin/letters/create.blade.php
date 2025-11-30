<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catat {{ $type == 'incoming' ? 'Surat Masuk' : 'Surat Keluar' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Gagal Menyimpan!</strong>
                    <ul class="mt-1 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.letters.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                
                @if($type == 'outgoing')
                    <input type="hidden" name="index_number" value="{{ $nextIndex }}">
                @endif

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-6">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Tanggal Surat</label>
                                <input type="date" name="letter_date" value="{{ old('letter_date', date('Y-m-d')) }}" 
                                       class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F] transition bg-gray-50 hover:bg-white" required>
                                @error('letter_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            @if($type == 'outgoing')
                                <div class="p-4 bg-purple-50 rounded-xl border border-purple-100">
                                    <label class="block text-xs font-bold text-[#83218F] uppercase tracking-wide mb-2">Pilih Jenis Surat</label>
                                    <select id="letterCodeSelect" name="letter_code" onchange="generateNumber()" 
                                            class="w-full border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-[#83218F] focus:border-[#83218F]">
                                        <option value="A" selected>Kode A (Internal Organisasi)</option>
                                        <option value="B">Kode B (Eksternal / Instansi Lain)</option>
                                        <option value="C">Kode C (Surat Tugas / Mandat)</option>
                                        <option value="D">Kode D (Keuangan / Laporan)</option>
                                        <option value="SPA">SPA (Surat Pengesahan)</option>
                                        <option value="SP">SP (Surat Peringatan)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nomor Surat (Otomatis)</label>
                                    <input type="text" name="reference_number" id="reference_number"
                                           value="{{ old('reference_number') }}"
                                           class="w-full font-mono font-bold text-gray-800 border-gray-300 rounded-xl px-4 py-3 bg-gray-50 focus:bg-white focus:ring-[#83218F] focus:border-[#83218F]" 
                                           required>
                                    <p class="text-[10px] text-gray-400 mt-1">*Pastikan nomor surat sudah muncul sebelum simpan.</p>
                                    @error('reference_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @else
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nomor Surat (Dari Pengirim)</label>
                                    <input type="text" name="reference_number" value="{{ old('reference_number') }}"
                                           class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" 
                                           placeholder="Contoh: 005/PC/A/..." required>
                                    @error('reference_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif

                        </div>

                        <div class="space-y-6">
                            
                            @if($type == 'incoming')
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Pengirim Surat</label>
                                    <input type="text" name="sender" value="{{ old('sender') }}"
                                           class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" 
                                           placeholder="Contoh: PC IPNU Kab. Garut" required>
                                    @error('sender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @else
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Tujuan / Kepada</label>
                                    <input type="text" name="recipient" value="{{ old('recipient') }}"
                                           class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" 
                                           placeholder="Contoh: Ketua PR IPNU Desa..." required>
                                    @error('recipient') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Perihal / Isi Ringkas</label>
                                <textarea name="subject" rows="4" 
                                          class="w-full border-gray-200 rounded-xl px-4 py-3 focus:ring-[#83218F] focus:border-[#83218F]" 
                                          placeholder="Contoh: Undangan Konferancab..." required>{{ old('subject') }}</textarea>
                                @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Scan File (Opsional)</label>
                                <input type="file" name="file" class="w-full border border-gray-200 rounded-xl p-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-50 file:text-[#83218F] hover:file:bg-purple-100">
                                <p class="text-[10px] text-gray-400 mt-1">PDF/JPG, Max 5MB</p>
                                @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-100 flex items-center gap-4">
                        <button type="submit" class="bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3.5 px-8 rounded-xl shadow-lg hover:shadow-xl transition transform active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Simpan Arsip
                        </button>
                        <a href="{{ route('admin.letters.index', ['type' => $type]) }}" class="text-gray-500 font-bold text-sm hover:text-gray-800 px-4">
                            Batal
                        </a>
                    </div>

                </div>
            </form>

        </div>
    </div>

    @if($type == 'outgoing')
    <script>
        const indexNumber = "{{ $formattedIndex }}";
        const romanMonth = "{{ $romanMonth }}";
        const year = "{{ $year }}";
        const orgCode = "73.54"; 

        function generateNumber() {
            const letterCode = document.getElementById('letterCodeSelect').value;
            // Format: 001/PAC/A/73.54/XI/2025
            const fullNumber = `${indexNumber}/PAC/${letterCode}/${orgCode}/${romanMonth}/${year}`;
            document.getElementById('reference_number').value = fullNumber;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Jalankan sekali saat load agar field tidak kosong
            generateNumber();
        });
    </script>
    @endif

</x-admin-layout>