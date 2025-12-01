<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image; // <--- PENTING: Import Library Gambar

class BiodataController extends Controller
{
    // Tampilkan Form Edit
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->profile;
        return view('member.biodata.edit', compact('user', 'profile'));
    }

    // Proses Update dengan Kompresi
    public function update(Request $request)
    {
        $user = $request->user();

        // 1. Validasi Input (Foto dilonggarkan jadi 10MB)
        $val = $request->validate([
            'phone' => 'required|numeric',
            'school_origin' => 'required|string|max:100',
            'address' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100', 
            'birth_date' => 'required|date',             
            'gender' => 'required|in:L,P',
            // Ubah max jadi 10240 (10MB) agar user leluasa upload foto HD
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240', 
        ]);

        // 2. Siapkan Data Dasar
        $data = collect($val)->except(['photo'])->toArray();

        // 3. PROSES FOTO (KOMPRESI)
        if ($request->hasFile('photo')) {
            
            // Hapus foto lama
            if ($user->profile && $user->profile->photo) {
                // Pastikan menghapus dari disk 'public'
                Storage::disk('public')->delete($user->profile->photo);
            }

            // Proses Image
            $imageFile = $request->file('photo');
            $filename = 'profiles/profile_' . $user->id . '_' . time() . '.webp'; // Tambahkan folder 'profiles/' di nama

            $manager = Image::read($imageFile);
            $manager->scale(width: 600);
            $encoded = $manager->toWebp(quality: 75);

            // PENTING: Gunakan disk('public') secara eksplisit
            Storage::disk('public')->put($filename, (string) $encoded);

            // Simpan path ke database
            $data['photo'] = $filename;
        }

        // 4. Update Database
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect()->back()->with('success', 'Biodata diperbarui & Foto berhasil dikompres!');
    }
}