<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Article; // Import Model Article
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\OrganizationStructure;
use App\Models\SocialMedia; // <--- TAMBAHKAN INI

class PublicEventController extends Controller
{
    // --- 1. HALAMAN LANDING PAGE (BERANDA) ---
    public function index()
    {
        // Data Event
        $events = Event::where('status', 'open')->latest()->get();
        
        // Data Artikel
        $articles = Article::with('author')
                    ->where('status', 'published')
                    ->latest()
                    ->take(3)
                    ->get();

        // Data Galeri
        $galleries = Gallery::latest()->take(5)->get();

        // Data Sosial Media (BARU)
        $socials = SocialMedia::all(); // <--- TAMBAHKAN INI

        // Kirim semua variabel ke view (tambahkan 'socials')
        return view('welcome', compact('events', 'articles', 'galleries', 'socials'));
    }

    // Halaman Lihat Semua Dokumentasi
    public function gallery()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('public.gallery', compact('galleries'));
    }

    // --- 2. HALAMAN BACA ARTIKEL (DETAIL) ---
    public function showArticle($slug)
    {
        $article = Article::with('author')
                    ->where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        return view('public.article', compact('article'));
    }

    // --- 3. FORMULIR PENDAFTARAN KEGIATAN ---
    public function showRegisterForm(Event $event)
    {
        // Pastikan event masih buka, kalau tutup redirect ke home
        if ($event->status !== 'open') {
            return redirect()->route('welcome')->with('error', 'Pendaftaran acara ini sudah ditutup.');
        }

        return view('public.register', compact('event'));
    }

    // --- 4. PROSES SIMPAN PENDAFTARAN ---
    public function store(Request $request, Event $event)
    {
        // A. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:100', // Tempat Lahir
            'birth_date' => 'required|date',             // Tanggal Lahir
            'phone' => 'required|numeric',
            'school_origin' => 'required|string|max:255',
            'address' => 'required|string',
            
            // Validasi File: Wajib Gambar/PDF max 2MB
            'payment_proof' => 'required|image|max:2048', 
            
            // Sertifikat hanya wajib jika event tipe 'lakmud'
            'certificate_file' => $event->type == 'lakmud' ? 'required|image|mimes:jpeg,png,jpg,pdf|max:2048' : 'nullable',
        ]);

        // B. Upload File Bukti Pembayaran
        $paymentPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentPath = $request->file('payment_proof')->store('payments', 'public');
        }

        // C. Upload File Sertifikat (Jika ada)
        $certPath = null;
        if ($request->hasFile('certificate_file')) {
            $certPath = $request->file('certificate_file')->store('certificates', 'public');
        }

        // D. Simpan ke Database
        Registration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'school_origin' => $request->school_origin,
            'address' => $request->address,
            'payment_proof' => $paymentPath,
            'certificate_file' => $certPath,
            'status' => 'pending' // Default pending, menunggu admin approve
        ]);

        // E. Redirect ke WhatsApp Admin
        $eventName = $event->title;
        // Ganti dengan nomor Admin/Sekretaris (Format: 628xxx)
        $adminPhone = '628xxxxxxxxxx'; 
        
        $message = "Assalamu'alaikum, saya *$request->name* telah mendaftar acara *$eventName*.\n\n"
                 . "Data diri dan bukti pembayaran sudah saya upload di website. Mohon diverifikasi. Terima kasih.";
        
        $waUrl = "https://wa.me/$adminPhone?text=" . urlencode($message);
        
        return redirect()->away($waUrl);
    }

    // Fungsi Download dari GDrive
public function downloadOriginal($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            
            // 1. Cek apakah kolom ada isinya
            if (!$gallery->original_image) {
                abort(404, 'Data file tidak ditemukan di database.');
            }

            $filename = $gallery->original_image;

            // 2. Cek apakah file benar-benar ada di Google Drive
            // Kita log dulu untuk memastikan path yang dicari benar
            Log::info("Mencoba download dari GDrive: " . $filename);

            if (!Storage::disk('google')->exists($filename)) {
                Log::error("File tidak ditemukan di GDrive: " . $filename);
                abort(404, 'File fisik tidak ditemukan di Cloud Storage.');
            }

            // 3. Ambil Mime Type (Jenis file)
            $mimeType = Storage::disk('google')->mimeType($filename);

            // 4. Lakukan Stream Download (Lebih stabil untuk Cloud)
            return response()->streamDownload(function () use ($filename) {
                echo Storage::disk('google')->get($filename);
            }, $filename, [
                'Content-Type' => $mimeType,
            ]);

        } catch (\Exception $e) {
            Log::error("Download Error: " . $e->getMessage());
            abort(500, 'Terjadi kesalahan server saat mengambil file.');
        }
    }

    public function structure()
    {
        $structures = OrganizationStructure::orderBy('level', 'asc')->get();
        return view('public.structure', compact('structures'));
    }
}