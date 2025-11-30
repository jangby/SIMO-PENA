<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    // Tampilkan Form Edit
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        return view('member.biodata.edit', compact('user', 'profile'));
    }

    // Proses Update
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input
        $val = $request->validate([
            'phone' => 'required|numeric',
            'school_origin' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100', 
            'birth_date' => 'required|date',             
            'gender' => 'required|in:L,P',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        // 2. Siapkan Data (Ambil semua input yang sudah divalidasi)
        // Kita exclude 'photo' dulu karena butuh penanganan khusus
        $data = collect($val)->except(['photo'])->toArray();

        // 3. Cek Upload Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($user->profile && $user->profile->photo) {
                Storage::delete('public/' . $user->profile->photo);
            }
            // Simpan foto baru
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        // 4. Eksekusi Simpan ke Database
        // Cari profile milik user ini, kalau ada update, kalau belum ada buat baru
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id], // Kunci pencarian
            $data // Data yang disimpan
        );

        return redirect()->back()->with('success', 'Biodata berhasil diperbarui!');
    }
}