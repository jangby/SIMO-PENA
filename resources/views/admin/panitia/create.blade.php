<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Panitia Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.panitia.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Nama Panitia')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('admin.panitia.index') }}" class="text-gray-600 hover:text-gray-900 underline text-sm">Batal</a>
                        <x-primary-button class="bg-[#83218F] hover:bg-purple-800">
                            {{ __('Buat Akun') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-admin-layout>