<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PanitiaAccountController extends Controller
{
    // Tampilkan daftar panitia
    public function index()
    {
        $panitias = User::where('role', 'panitia')->latest()->get();
        return view('admin.panitia.index', compact('panitias'));
    }

    // Tampilkan form tambah panitia
    public function create()
    {
        return view('admin.panitia.create');
    }

    // Proses simpan data panitia baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 1. Buat User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'panitia', // Set role otomatis jadi panitia
            'is_active' => true,
        ]);

        // 2. Buat Profile kosong (Penting agar tidak error saat memanggil foto profil)
        Profile::create([
            'user_id' => $user->id,
            // Field lain biarkan null/default
        ]);

        return redirect()->route('admin.panitia.index')->with('success', 'Akun Panitia berhasil dibuat.');
    }

    // Hapus akun panitia
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Proteksi agar tidak bisa hapus admin via menu ini
        if($user->role !== 'panitia') {
            return back()->with('error', 'Hanya akun panitia yang boleh dihapus.');
        }

        $user->delete();
        return back()->with('success', 'Akun Panitia berhasil dihapus.');
    }
}