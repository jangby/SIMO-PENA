<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Sosial Media</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Tambah / Update Link</h3>
                        
                        <form action="{{ route('admin.socials.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Platform</label>
                                <select name="platform" class="w-full border-gray-200 rounded-xl mt-1 focus:ring-[#83218F] focus:border-[#83218F]">
                                    <option value="instagram">Instagram</option>
                                    <option value="tiktok">TikTok</option>
                                    <option value="youtube">YouTube</option>
                                    <option value="facebook">Facebook</option>
                                    <option value="twitter">X (Twitter)</option>
                                    <option value="website">Website / Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Link URL (Lengkap)</label>
                                <input type="url" name="url" placeholder="https://..." required
                                       class="w-full border-gray-200 rounded-xl mt-1 focus:ring-[#83218F] focus:border-[#83218F]">
                            </div>

                            <button type="submit" class="w-full bg-[#83218F] hover:bg-purple-800 text-white font-bold py-3 rounded-xl shadow-md transition">
                                Simpan Link
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4">Sosial Media Aktif</h3>
                        
                        @if($socials->isEmpty())
                            <p class="text-gray-400 text-sm text-center py-8">Belum ada sosial media ditambahkan.</p>
                        @else
                            <div class="space-y-3">
                                @foreach($socials as $soc)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold shadow-sm
                                            {{ $soc->platform == 'instagram' ? 'bg-pink-600' : '' }}
                                            {{ $soc->platform == 'tiktok' ? 'bg-black' : '' }}
                                            {{ $soc->platform == 'youtube' ? 'bg-red-600' : '' }}
                                            {{ $soc->platform == 'facebook' ? 'bg-blue-600' : '' }}
                                            {{ $soc->platform == 'twitter' ? 'bg-gray-800' : '' }}
                                            {{ $soc->platform == 'website' ? 'bg-green-600' : '' }}
                                        ">
                                            {{ substr(ucfirst($soc->platform), 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800 capitalize">{{ $soc->platform }}</h4>
                                            <a href="{{ $soc->url }}" target="_blank" class="text-xs text-blue-500 hover:underline truncate max-w-[200px] block">
                                                {{ $soc->url }}
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('admin.socials.destroy', $soc->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-400 hover:text-red-600 p-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>