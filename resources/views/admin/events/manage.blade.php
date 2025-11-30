<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.events.index') }}" class="p-2 bg-white rounded-lg text-gray-500 hover:text-[#83218F] shadow-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="font-bold text-xl text-gray-800 leading-tight">{{ $event->title }}</h2>
                <p class="text-xs text-gray-500 flex items-center gap-2">
                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded uppercase font-bold">{{ $event->type }}</span>
                    {{ $event->start_time->format('d M Y') }} • {{ $event->location }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-purple-50 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:scale-110 transition text-[#83218F]">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Pendaftar</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total'] }}</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-green-50 flex flex-col justify-between h-32 relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10 text-green-600">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Peserta Resmi</p>
                    <h3 class="text-3xl font-black text-green-600">{{ $stats['approved'] }}</h3>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-yellow-50 flex flex-col justify-between h-32 relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-10 text-yellow-600">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Pending</p>
                    <h3 class="text-3xl font-black text-yellow-600">{{ $stats['pending'] }}</h3>
                </div>

                @php $hadir = $event->registrations()->whereNotNull('presence_at')->count(); @endphp
                <div class="bg-[#83218F] p-5 rounded-2xl shadow-lg shadow-purple-200 flex flex-col justify-between h-32 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 p-4 opacity-20">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <p class="text-purple-100 text-xs font-bold uppercase tracking-wider">Kehadiran (Check-in)</p>
                    <h3 class="text-3xl font-black">{{ $hadir }}</h3>
                </div>
            </div>

            <h3 class="font-bold text-gray-700 text-lg px-1 mt-4">Menu Kelola</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <a href="{{ route('admin.events.participants', $event->id) }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-[#83218F] hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">Data Peserta</h4>
                    <p class="text-sm text-gray-500 mt-1">Export Excel, lihat detail peserta, dan hubungi via WA.</p>
                </a>

                <a href="{{ route('admin.events.schedules', $event->id) }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-yellow-400 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-xl flex items-center justify-center mb-4 group-hover:bg-yellow-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">Jadwal / Rundown</h4>
                    <p class="text-sm text-gray-500 mt-1">Atur susunan acara agar muncul di HP peserta.</p>
                </a>

                <a href="{{ route('admin.events.attendance', $event->id) }}" class="group bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:border-[#83218F] hover:shadow-md transition">
                    <div class="w-12 h-12 bg-purple-50 text-[#83218F] rounded-xl flex items-center justify-center mb-4 group-hover:bg-[#83218F] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h4 class="font-bold text-gray-800 text-lg">Absensi Digital</h4>
                    <p class="text-sm text-gray-500 mt-1">Scan QR Code peserta untuk pencatatan kehadiran.</p>
                </a>

            </div>
        </div>
    </div>
</x-admin-layout>