<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    /**
     * Menampilkan daftar organisasi (PR & PK).
     */
    public function index()
    {
        // Kita ambil semua data, kecuali PAC (karena PAC biasanya cuma satu dan statis/induk)
        // Atau ambil semua juga boleh. Di sini kita urutkan berdasarkan tipe lalu nama.
        $organizations = Organization::orderBy('type', 'asc')
                                     ->orderBy('name', 'asc')
                                     ->get();

        return view('admin.organizations.index', compact('organizations'));
    }

    /**
     * Menampilkan form tambah organisasi.
     */
    public function create()
    {
        return view('admin.organizations.create');
    }

    /**
     * Menyimpan data organisasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:PAC,PR,PK',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048', // Maksimal 2MB
        ]);

        $data = $request->all();

        // Handle Upload Logo
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }

        Organization::create($data);

        return redirect()->route('admin.organizations.index')
                         ->with('success', 'Organisasi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Organization $organization)
    {
        return view('admin.organizations.edit', compact('organization'));
    }

    /**
     * Update data organisasi.
     */
    public function update(Request $request, Organization $organization)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:PAC,PR,PK',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Handle Ganti Logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($organization->logo) {
                Storage::delete('public/' . $organization->logo);
            }
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }

        $organization->update($data);

        return redirect()->route('admin.organizations.index')
                         ->with('success', 'Data organisasi diperbarui!');
    }

    /**
     * Hapus organisasi.
     */
    public function destroy(Organization $organization)
    {
        // Cek dulu apakah organisasi ini punya anggota?
        // Jika ya, sebaiknya jangan dihapus sembarangan atau gunakan soft delete.
        // Untuk sekarang kita asumsikan hapus permanen + logonya.

        if ($organization->users()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Organisasi ini masih memiliki anggota/admin.');
        }

        if ($organization->logo) {
            Storage::delete('public/' . $organization->logo);
        }

        $organization->delete();

        return back()->with('success', 'Organisasi berhasil dihapus.');
    }
}