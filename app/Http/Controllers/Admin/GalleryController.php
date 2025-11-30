<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Tampilkan Galeri
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    // Form Upload
    public function create()
    {
        return view('admin.galleries.create');
    }

    // Simpan Foto
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5048', // Max 5MB
        ]);

        $path = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'image' => $path,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Foto berhasil diupload!');
    }

    // Hapus Foto
    public function destroy(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::delete('public/' . $gallery->image);
        }
        
        $gallery->delete();
        
        return redirect()->back()->with('success', 'Foto dihapus.');
    }
}