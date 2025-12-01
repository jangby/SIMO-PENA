<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image; // <--- PENTING: Import Facade Ini

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    // --- FUNGSI STORE DENGAN KOMPRESI ---
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        try {
            $imageFile = $request->file('image');
            
            // A. PROSES UNTUK VPS (WEBP KECIL)
            // ------------------------------------
            $filenameWebp = time() . '_' . uniqid() . '.webp';
            
            // Resize & Compress
            $manager = Image::read($imageFile);
            $manager->scale(width: 800);
            $encoded = $manager->toWebp(quality: 75);

            // Simpan di VPS (public disk)
            Storage::disk('public')->put('gallery/' . $filenameWebp, (string) $encoded);


            // B. PROSES UNTUK GOOGLE DRIVE (ASLI BESAR)
            // ------------------------------------
            $filenameOriginal = time() . '_HD_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
            
            // Simpan file asli langsung ke Google Drive
            // getClientOriginalName() atau buat nama baru
            Storage::disk('google')->put($filenameOriginal, file_get_contents($imageFile));


            // C. SIMPAN DATABASE
            Gallery::create([
                'title' => $request->title,
                'image' => 'gallery/' . $filenameWebp, // Path lokal (cepat)
                'original_image' => $filenameOriginal, // Nama file di GDrive
            ]);

            return redirect()->route('admin.galleries.index')->with('success', 'Foto HD tersimpan di Google Drive & WebP di Server!');

        } catch (\Exception $e) {
            return back()->withErrors(['image' => 'Gagal upload: ' . $e->getMessage()])->withInput();
        }
    }

    public function destroy(Gallery $gallery)
    {
        // Hapus WebP di VPS
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        // Hapus Original di Google Drive
        if ($gallery->original_image) {
            Storage::disk('google')->delete($gallery->original_image);
        }
        
        $gallery->delete();
        return redirect()->back()->with('success', 'Foto dihapus dari Server & GDrive.');
    }

    // --- FITUR SINKRONISASI GOOGLE DRIVE ---
    // --- FITUR SINKRONISASI GOOGLE DRIVE (FIXED) ---
    public function syncGoogleDrive()
    {
        try {
            // PERBAIKAN: Gunakan method files() dengan argumen string kosong '' (root)
            // Ini akan mengembalikan array path file: ['foto1.jpg', 'foto2.png', ...]
            $files = Storage::disk('google')->files(''); 

            $count = 0;

            foreach ($files as $filePath) {
                // $filePath adalah string nama file di GDrive
                
                // 1. Pastikan file tersebut adalah gambar
                if ($this->isImage($filePath)) {
                    
                    // 2. Cek database (hindari duplikat)
                    $exists = Gallery::where('original_image', $filePath)->exists();

                    if (!$exists) {
                        // --- PROSES IMPORT ---
                        
                        // A. Ambil isi file dari Google Drive
                        $fileContent = Storage::disk('google')->get($filePath);
                        
                        // B. Buat Thumbnail WebP di VPS
                        $filenameWebp = 'imported_' . uniqid() . '.webp';
                        
                        // Proses dengan Intervention Image
                        $manager = Image::read($fileContent);
                        $manager->scale(width: 800); // Resize biar ringan
                        $encoded = $manager->toWebp(quality: 75);
                        
                        // Simpan ke VPS
                        Storage::disk('public')->put('gallery/' . $filenameWebp, (string) $encoded);

                        // C. Catat ke Database
                        Gallery::create([
                            'title' => pathinfo($filePath, PATHINFO_FILENAME), // Nama file jadi judul
                            'image' => 'gallery/' . $filenameWebp, // Path lokal (WebP)
                            'original_image' => $filePath, // Path GDrive (Asli)
                        ]);

                        $count++;
                    }
                }
            }

            if ($count > 0) {
                return back()->with('success', "Berhasil menarik $count foto baru dari Google Drive!");
            } else {
                return back()->with('success', 'Semua foto di Google Drive sudah tersinkronisasi.');
            }

        } catch (\Exception $e) {
            // Tampilkan error spesifik untuk debugging
            return back()->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }

    // Helper untuk cek ekstensi gambar
    private function isImage($path)
    {
        $extensions = ['jpg', 'jpeg', 'png', 'webp', 'bmp'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return in_array($ext, $extensions);
    }
}