<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-30 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-[#83218F]" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-8 gap-2">
                    
                    {{-- 1. Dashboard --}}
                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-full text-sm font-bold transition duration-300 ease-in-out
                       {{ request()->routeIs('dashboard') 
                          ? 'bg-[#83218F] text-white shadow-md shadow-purple-200' 
                          : 'text-gray-500 hover:bg-purple-50 hover:text-[#83218F]' }}">
                        Dashboard
                    </a>
                    
                    {{-- Separator Kecil --}}
                    <div class="h-6 w-px bg-gray-200 mx-2"></div>

                    {{-- 2. Biodata --}}
                    <a href="{{ route('biodata.edit') }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('biodata.*') 
                          ? 'bg-[#83218F] text-white shadow-md shadow-purple-200' 
                          : 'text-gray-500 hover:bg-purple-50 hover:text-[#83218F]' }}">
                        Biodata
                    </a>

                    {{-- 3. Kegiatan Saya --}}
                    <a href="{{ route('my-events.index') }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('my-events.*') 
                          ? 'bg-[#83218F] text-white shadow-md shadow-purple-200' 
                          : 'text-gray-500 hover:bg-purple-50 hover:text-[#83218F]' }}">
                        Kegiatan
                    </a>

                    {{-- 4. Kabar IPNU --}}
                    <a href="{{ route('member.articles.index') }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('member.articles.*') 
                          ? 'bg-[#83218F] text-white shadow-md shadow-purple-200' 
                          : 'text-gray-500 hover:bg-purple-50 hover:text-[#83218F]' }}">
                        Berita
                    </a>

                    {{-- 5. Absensi --}}
                    <a href="{{ route('member.attendance.index') }}" 
                       class="px-4 py-2 rounded-full text-sm font-medium transition duration-300 ease-in-out
                       {{ request()->routeIs('member.attendance.*') 
                          ? 'bg-[#83218F] text-white shadow-md shadow-purple-200' 
                          : 'text-gray-500 hover:bg-purple-50 hover:text-[#83218F]' }}">
                        Absensi
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-full text-gray-500 bg-gray-50 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile Saya') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-600 hover:bg-red-50">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-2">
            
            {{-- Mobile Link Item --}}
            <a href="{{ route('dashboard') }}" 
               class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium transition duration-200
               {{ request()->routeIs('dashboard') 
                  ? 'bg-purple-50 text-[#83218F] font-bold border-l-4 border-[#83218F]' 
                  : 'text-gray-600 hover:bg-gray-50' }}">
                Dashboard
            </a>

            <a href="{{ route('biodata.edit') }}" 
               class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium transition duration-200
               {{ request()->routeIs('biodata.*') 
                  ? 'bg-purple-50 text-[#83218F] font-bold border-l-4 border-[#83218F]' 
                  : 'text-gray-600 hover:bg-gray-50' }}">
                Biodata Anggota
            </a>

            <a href="{{ route('my-events.index') }}" 
               class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium transition duration-200
               {{ request()->routeIs('my-events.*') 
                  ? 'bg-purple-50 text-[#83218F] font-bold border-l-4 border-[#83218F]' 
                  : 'text-gray-600 hover:bg-gray-50' }}">
                Kegiatan Saya
            </a>

            <a href="{{ route('member.articles.index') }}" 
               class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium transition duration-200
               {{ request()->routeIs('member.articles.*') 
                  ? 'bg-purple-50 text-[#83218F] font-bold border-l-4 border-[#83218F]' 
                  : 'text-gray-600 hover:bg-gray-50' }}">
                Kabar IPNU
            </a>

            <a href="{{ route('member.attendance.index') }}" 
               class="block pl-3 pr-4 py-3 rounded-lg text-base font-medium transition duration-200
               {{ request()->routeIs('member.attendance.*') 
                  ? 'bg-purple-50 text-[#83218F] font-bold border-l-4 border-[#83218F]' 
                  : 'text-gray-600 hover:bg-gray-50' }}">
                Riwayat Absensi
            </a>

        </div>

        <div class="pt-4 pb-4 border-t border-gray-100 bg-gray-50">
            <div class="px-4 flex items-center gap-3">
                <div class="bg-purple-100 p-2 rounded-full text-[#83218F]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <div>
                    <div class="font-bold text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-4 space-y-1 px-2">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-white rounded-lg">
                    {{ __('Profile Saya') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-4 py-2 text-base font-bold text-red-600 hover:bg-red-50 rounded-lg">
                        {{ __('Keluar') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>