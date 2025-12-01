<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    public function index()
    {
        $socials = SocialMedia::all();
        return view('admin.socials.index', compact('socials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'platform' => 'required|string',
            'url' => 'required|url'
        ]);

        // Cek apakah platform sudah ada? (Opsional: update jika ada, atau tambah baru)
        // Disini kita buat updateOrCreate biar satu platform cuma 1 link
        SocialMedia::updateOrCreate(
            ['platform' => $request->platform],
            ['url' => $request->url]
        );

        return back()->with('success', 'Sosial media berhasil disimpan!');
    }

    public function destroy(SocialMedia $socialMedia)
    {
        $socialMedia->delete();
        return back()->with('success', 'Link dihapus.');
    }
}