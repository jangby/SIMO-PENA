<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - PAC IPNU</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,600,700&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="bg-[#83218F] pt-8 pb-32 px-6 relative rounded-b-[3rem] shadow-xl overflow-hidden">
        
        <div class="absolute top-0 left-0 w-40 h-40 bg-white opacity-5 rounded-full blur-3xl -ml-10 -mt-10"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-yellow-400 opacity-10 rounded-full blur-3xl -mr-10 -mb-10"></div>

        <div class="relative z-10 flex justify-between items-center mb-8">
            <a href="{{ route('welcome') }}" class="p-2.5 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl text-white hover:bg-white/20 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <span class="text-white/80 text-xs font-bold tracking-widest uppercase">Portal Anggota</span>
            <div class="w-10"></div> </div>

        <div class="relative z-10 text-center">
            <div class="inline-block p-3 bg-white/10 backdrop-blur-sm rounded-full mb-4 shadow-inner border border-white/10">
                <img src="{{ asset('logo/logopena.jpg') }}" class="w-12 h-12 object-contain drop-shadow-md">
            </div>
            <h1 class="text-2xl font-extrabold text-white mb-1">Gabung Bersama Kami</h1>
            <p class="text-purple-200 text-xs font-medium">Buat akun untuk mengakses fitur eksklusif.</p>
        </div>
    </div>

    <div class="max-w-md mx-auto px-6 -mt-16 relative z-20 pb-10">
        <div class="bg-white rounded-[2rem] shadow-xl p-8 border border-gray-100">
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama sesuai KTP"
                               class="pl-11 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="contoh@email.com"
                               class="pl-11 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter"
                               class="pl-11 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1.5 ml-1">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password"
                               class="pl-11 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-[#83218F] text-white py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-purple-200 hover:bg-purple-800 transition transform active:scale-95 flex justify-center items-center">
                        Daftar Akun Baru
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </div>

                <div class="text-center mt-6">
                    <p class="text-xs text-gray-500">Sudah memiliki akun?</p>
                    <a href="{{ route('login') }}" class="text-[#83218F] font-bold text-sm hover:underline mt-1 inline-block">
                        Masuk disini
                    </a>
                </div>
            </form>
        </div>
        
        <p class="text-center text-[10px] text-gray-400 mt-8">&copy; {{ date('Y') }} PENA Limbangan</p>
    </div>

</body>
</html>