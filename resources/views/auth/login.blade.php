<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Anggota - PAC IPNU</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <div class="bg-[#83218F] pt-12 pb-32 px-4 relative rounded-b-[3rem] shadow-lg overflow-hidden">
        
        <div class="absolute top-0 left-0 -ml-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 -mr-10 -mb-10 w-40 h-40 bg-yellow-400 opacity-10 rounded-full blur-3xl"></div>

        <div class="relative z-10 flex flex-col items-center justify-center text-center">
            <div class="bg-white p-3 rounded-full shadow-2xl mb-4 animate-bounce-slow">
                <img src="{{ asset('logo/logopena.jpg') }}" class="w-16 h-16">
            </div>
            <h1 class="text-white font-bold text-2xl tracking-wide">PENA</h1>
            <p class="text-purple-200 text-xs uppercase tracking-widest mt-1">Kecamatan Limbangan</p>
        </div>
    </div>

    <div class="max-w-md mx-auto px-6 -mt-20 relative z-20">
        <div class="bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
            
            <h2 class="text-center font-bold text-gray-800 text-lg mb-6">Masuk Aplikasi</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Email / Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input id="email" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" 
                               type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email anda">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1 ml-1">Password</label>
                    <div class="relative x-data="{ show: false }">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" class="pl-10 block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-[#83218F] focus:ring-[#83218F] transition py-3 text-sm placeholder-gray-400" 
                               type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#83218F] shadow-sm focus:ring-[#83218F]" name="remember">
                        <span class="ml-2 text-xs text-gray-600">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-xs text-[#83218F] hover:text-purple-700 font-semibold" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-[#83218F] text-white py-3.5 rounded-xl font-bold shadow-lg shadow-purple-200 hover:bg-purple-800 transition transform active:scale-95 flex justify-center items-center uppercase tracking-wide text-sm">
                    Masuk Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </button>
            </form>
        </div>

        <div class="text-center mt-8 pb-8">
            <p class="text-gray-500 text-sm">Belum punya akun?</p>
            <a href="{{ route('welcome') }}#event-list" class="text-[#83218F] font-bold text-sm hover:underline mt-1 inline-block">
                Daftar via Kegiatan (Event)
            </a>
            <p class="text-[10px] text-gray-400 mt-6">&copy; {{ date('Y') }} PAC IPNU Limbangan</p>
        </div>
    </div>

    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-3%); }
            50% { transform: translateY(3%); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s infinite ease-in-out;
        }
    </style>
</body>
</html>