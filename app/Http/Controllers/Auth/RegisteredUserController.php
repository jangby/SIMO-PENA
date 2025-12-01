<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'numeric'], // Validasi No WA
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'is_active' => false, // <--- Set Default Nonaktif
        ]);

        // Buat Profile dengan Grade 'Calon' dan simpan No WA
        $user->profile()->create([
            'phone' => $request->phone,
            'grade' => 'calon',
        ]);

        // Jangan login otomatis!
        // Auth::login($user); 

        // Redirect ke halaman info
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun Anda sedang diverifikasi admin. Notifikasi akan dikirim via WhatsApp.');
    }
}
