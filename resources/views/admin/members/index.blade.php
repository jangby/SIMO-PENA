<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Database Keanggotaan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex space-x-2 bg-white p-1.5 rounded-xl w-fit mb-6 shadow-sm border border-gray-100">
                <a href="{{ route('admin.members.index', ['grade' => 'anggota']) }}" 
                   class="px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 {{ $grade == 'anggota' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                   <div class="p-1 bg-white/20 rounded-full">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                   </div>
                   Anggota (Makesta)
                </a>
                <a href="{{ route('admin.members.index', ['grade' => 'kader']) }}" 
                   class="px-5 py-2.5 rounded-lg text-sm font-bold transition flex items-center gap-2 {{ $grade == 'kader' ? 'bg-[#83218F] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}">
                   <div class="p-1 bg-white/20 rounded-full">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                   </div>
                   Kader (Lakmud)
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
                    
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-gray-800">
                            Daftar {{ ucfirst($grade) }} ({{ $members->total() }})
                        </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-500">
                            <thead class="bg-[#83218F] text-white uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4 rounded-tl-xl">Profil Anggota</th>
                                    <th class="px-6 py-4">Asal Sekolah</th>
                                    <th class="px-6 py-4">Kontak (WA)</th>
                                    <th class="px-6 py-4 text-center">Kelengkapan Data</th>
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
                                        <span class="text-gray-700 font-medium">{{ $member->profile->school_origin ?? '-' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($member->profile && $member->profile->phone)
                                            <a href="https://wa.me/{{ $member->profile->phone }}" target="_blank" class="text-green-600 font-bold hover:underline flex items-center gap-1 bg-green-50 w-fit px-2 py-1 rounded-md">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.463 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                {{ $member->profile->phone }}
                                            </a>
                                        @else
                                            <span class="text-gray-300 text-xs italic">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($member->profile && $member->profile->nia_ipnu)
                                            <span class="bg-green-100 text-green-700 text-[10px] font-bold px-2 py-1 rounded-full border border-green-200">TERVERIFIKASI</span>
                                        @elseif($member->profile)
                                            <span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-1 rounded-full border border-blue-200">DATA LENGKAP</span>
                                        @else
                                            <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-1 rounded-full border border-red-200">BELUM LENGKAP</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('admin.members.show', $member->id) }}" class="inline-flex items-center gap-1 bg-white border border-gray-200 text-gray-600 hover:text-[#83218F] hover:border-[#83218F] font-bold text-xs px-3 py-1.5 rounded-lg transition shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            </div>
                                            <p class="font-medium text-sm">Belum ada data {{ $grade }} ditemukan.</p>
                                            @if(request('search'))
                                                <p class="text-xs mt-1">Coba kata kunci lain.</p>
                                            @endif
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