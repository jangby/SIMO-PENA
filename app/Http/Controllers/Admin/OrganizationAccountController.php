<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class OrganizationAccountController extends Controller
{
    /**
     * Menampilkan daftar Admin untuk Organisasi tertentu
     */
    public function index(Organization $organization)
    {
        // Ambil user yang role-nya admin DAN id organisasinya sesuai
        $admins = User::where('organization_id', $organization->id)
                      ->where('role', 'admin')
                      ->get();

        return view('admin.organizations.accounts', compact('organization', 'admins'));
    }

    /**
     * Membuat akun Admin baru untuk Organisasi ini
     */
    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Set sebagai Admin
            'organization_id' => $organization->id, // Kunci ke organisasi ini
            'is_active' => true,
            'email_verified_at' => now(), // Langsung verifikasi agar tidak perlu email
        ]);

        return back()->with('success', 'Akun admin berhasil dibuat!');
    }

    /**
     * Menghapus akses admin
     */
    public function destroy(Organization $organization, User $user)
    {
        // Pastikan user yang dihapus memang milik organisasi ini
        if ($user->organization_id !== $organization->id) {
            return back()->with('error', 'Tidak bisa menghapus user dari organisasi lain.');
        }

        // Hapus user (Soft Delete sesuai model User kamu)
        $user->delete();

        return back()->with('success', 'Akses admin dicabut (User dihapus).');
    }
}