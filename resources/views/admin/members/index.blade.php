<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Database Keanggotaan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl shadow-sm flex justify-between items-center">
                    <span class="font-bold text-sm flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ session('success') }}
                    </span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            <div class="flex flex-wrap gap-2 bg-white p-2 rounded-2xl w-full mb-6 shadow-sm border border-gray-100 overflow-x-auto">
                
                <a href="{{ route('admin.members.index', ['grade' => 'calon']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 whitespace-nowrap {{ $grade == 'calon' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   Calon Anggota
                   @if($grade == 'calon') <span class="bg-white text-[#83218F] text-[10px] px-1.5 rounded-full">{{ $members->total() }}</span> @endif
                </a>

                <a href="{{ route('admin.members.index', ['grade' => 'anggota']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 whitespace-nowrap {{ $grade == 'anggota' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   Anggota (Makesta)
                </a>

                <a href="{{ route('admin.members.index', ['grade' => 'kader']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 whitespace-nowrap {{ $grade == 'kader' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   Kader (Lakmud)
                </a>

                <a href="{{ route('admin.members.index', ['grade' => 'alumni']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 whitespace-nowrap {{ $grade == 'alumni' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                   Alumni
                </a>

                <a href="{{ route('admin.members.index', ['grade' => 'sampah']) }}" 
                   class="px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2 whitespace-nowrap {{ $grade == 'sampah' ? 'bg-red-600 text-white shadow-md' : 'text-gray-500 hover:bg-red-50 hover:text-red-600' }}">
                   Sampah
                </a>
            </div>
            
            <div class="bg-white p-4 rounded-2xl shadow-sm mb-6 flex flex-col md:flex-row justify-between items-center gap-4 border border-gray-100">
                
                <form action="{{ route('admin.members.index') }}" method="GET" class="w-full md:w-1/2 relative">
                    <input type="hidden" name="grade" value="{{ $grade }}">
                    
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari nama, email, atau sekolah..." 
                               class="w-full pl-11 pr-4 py-2.5 border-gray-200 rounded-xl focus:ring-[#83218F] focus:border-[#83218F] text-sm bg-gray-50 hover:bg-white transition">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                <a href="{{ route('admin.members.export') }}" class="flex items-center gap-2 bg-green-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-green-700 transition shadow-md w-full md:w-auto justify-center transform active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Export Excel
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-[#83218F] text-white uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4 rounded-tl-xl">Profil</th>
                                    <th class="px-6 py-4">Identitas</th>
                                    <th class="px-6 py-4">Kontak</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($members as $member)
                                <tr class="hover:bg-purple-50 transition group">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-[#83218F] font-bold uppercase mr-3 border-2 border-white shadow-sm overflow-hidden">
                                                @if($member->profile && $member->profile->photo)
                                                    <img src="{{ asset('storage/' . $member->profile->photo) }}" class="h-full w-full object-cover">
                                                @else
                                                    {{ substr($member->name, 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                <div class="font-bold text-gray-900 group-hover:text-[#83218F] transition">{{ $member->name }}</div>
                                                <div class="text-xs text-gray-400">{{ $member->email }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="block text-gray-800 font-bold text-xs">{{ $member->profile->school_origin ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-500">NIA: {{ $member->profile->nia_ipnu ?? 'Belum ada' }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($member->profile && $member->profile->phone)
                                            <a href="https://wa.me/{{ $member->profile->phone }}" target="_blank" class="text-green-600 font-bold hover:underline flex items-center gap-1 bg-green-50 w-fit px-2 py-1 rounded-md">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                {{ $member->profile->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-xs italic">No Phone</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if($member->is_active)
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            
                                            @if($grade == 'sampah')
                                                <form action="{{ route('admin.members.restore', $member->id) }}" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit" class="bg-green-100 text-green-700 p-2 rounded-lg hover:bg-green-200 transition" title="Pulihkan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.members.force_delete', $member->id) }}" method="POST" onsubmit="return confirm('Hapus PERMANEN? Data tidak bisa kembali!')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-100 text-red-600 p-2 rounded-lg hover:bg-red-200 transition" title="Hapus Permanen">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            
                                            @else
                                                @if(!$member->is_active)
                                                    <form action="{{ route('admin.members.activate', $member->id) }}" method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="bg-green-600 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg shadow hover:bg-green-700 transition" onclick="return confirm('Aktifkan akun ini?')">
                                                            Aktifkan
                                                        </button>
                                                    </form>
                                                @endif

                                                @if($member->is_active)
                                                    <form action="{{ route('admin.members.deactivate', $member->id) }}" method="POST" onsubmit="return confirm('Nonaktifkan (Ban) akun ini?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="bg-yellow-50 text-yellow-600 p-2 rounded-lg hover:bg-yellow-100 transition" title="Nonaktifkan">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <a href="{{ route('admin.members.show', $member->id) }}" class="bg-white border border-gray-200 text-gray-600 p-2 rounded-lg hover:border-[#83218F] hover:text-[#83218F] transition" title="Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>

                                                @if($grade != 'alumni' && $grade != 'calon')
                                                    <form action="{{ route('admin.members.graduate', $member->id) }}" method="POST" onsubmit="return confirm('Nyatakan anggota ini LULUS?')">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="bg-blue-50 text-blue-600 p-2 rounded-lg hover:bg-blue-100 transition" title="Jadikan Alumni">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('admin.members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Pindahkan ke Sampah?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="bg-red-50 text-red-600 p-2 rounded-lg hover:bg-red-100 transition" title="Hapus Sementara">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <p class="font-medium text-sm">Belum ada data {{ ucfirst($grade) }} ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 border-t border-gray-100 pt-4">
                        {{ $members->withQueryString()->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>