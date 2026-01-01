<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Data Anggota
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <form action="{{ route('admin.members.update', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-between items-center mb-6 border-b pb-4">
                        <h3 class="text-lg font-bold text-gray-700">Form Perubahan Data</h3>
                        <a href="{{ route('admin.members.index') }}" class="text-sm text-gray-500 hover:text-[#83218F]">Kembali</a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase">Informasi Akun</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                                    class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                                    class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                                <input type="number" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}" required 
                                    class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h4 class="text-xs font-bold text-gray-400 uppercase">Biodata & Organisasi</h4>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tingkatan</label>
                                    <select name="grade" class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                                        <option value="calon" {{ (old('grade', $user->profile->grade ?? '') == 'calon') ? 'selected' : '' }}>Calon Anggota</option>
                                        <option value="anggota" {{ (old('grade', $user->profile->grade ?? '') == 'anggota') ? 'selected' : '' }}>Anggota (Makesta)</option>
                                        <option value="kader" {{ (old('grade', $user->profile->grade ?? '') == 'kader') ? 'selected' : '' }}>Kader (Lakmud)</option>
                                        <option value="alumni" {{ (old('grade', $user->profile->grade ?? '') == 'alumni') ? 'selected' : '' }}>Alumni</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gender</label>
                                    <select name="gender" class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                                        <option value="L" {{ (old('gender', $user->profile->gender ?? '') == 'L') ? 'selected' : '' }}>Laki-laki (IPNU)</option>
                                        <option value="P" {{ (old('gender', $user->profile->gender ?? '') == 'P') ? 'selected' : '' }}>Perempuan (IPPNU)</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Asal Sekolah / Instansi</label>
                                <input type="text" name="school_origin" value="{{ old('school_origin', $user->profile->school_origin ?? '') }}" required 
                                    class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                                    <input type="text" name="birth_place" value="{{ old('birth_place', $user->profile->birth_place ?? '') }}" 
                                        class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                    <input type="date" name="birth_date" value="{{ old('birth_date', $user->profile->birth_date ?? '') }}" 
                                        class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Induk (NIA)</label>
                                <input type="text" name="nia_ipnu" value="{{ old('nia_ipnu', $user->profile->nia_ipnu ?? '') }}" placeholder="Opsional"
                                    class="mt-1 w-full rounded-xl border-gray-300 focus:border-[#83218F] focus:ring focus:ring-[#83218F] focus:ring-opacity-20">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <a href="{{ route('admin.members.index') }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">Batal</a>
                        <button type="submit" class="px-5 py-2.5 bg-[#83218F] text-white font-bold rounded-xl hover:bg-purple-800 shadow-md transition">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-admin-layout>