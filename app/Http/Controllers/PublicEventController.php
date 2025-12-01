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
        // --- 1. CEK DUPLIKAT (LOGIKA BARU) ---
        // Cek apakah nomor ini sudah ada di event ini?
        $existing = Registration::where('event_id', $event->id) // Event yang sama
                                ->where('phone', $request->phone) // No WA yang sama
                                ->whereIn('status', ['pending', 'approved']) // Status masih aktif
                                ->first();

        if ($existing) {
            // Jika sudah ada, kembalikan ke form dengan pesan error
            $statusMsg = $existing->status == 'approved' ? 'sudah terdaftar resmi' : 'sedang menunggu verifikasi';
            
            return back()
                ->withInput() // Kembalikan isian form agar tidak ngetik ulang
                ->withErrors(['phone' => "Nomor WhatsApp ini $statusMsg di acara ini!"]);
        }
        // -------------------------------------

        $isPaid = $event->price > 0;

        // 2. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:L,P',
            'birth_place' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'phone' => 'required|numeric',
            'school_origin' => 'required|string|max:255',
            
            // Validasi Alamat Terpisah
            'addr_street' => 'required|string',
            'addr_rt' => 'required|numeric',
            'addr_rw' => 'required|numeric',
            'addr_village' => 'required|string',
            'addr_district' => 'required|string',
            'addr_regency' => 'required|string',
            'addr_postal' => 'nullable|numeric',
            
            'payment_proof' => $isPaid ? 'required|image|max:2048' : 'nullable',
            'certificate_file' => $event->type == 'lakmud' ? 'required|image|mimes:jpeg,png,jpg,pdf|max:2048' : 'nullable',
        ]);

        // 3. GABUNGKAN ALAMAT
        $fullAddress = "{$request->addr_street}, RT {$request->addr_rt} / RW {$request->addr_rw}, Ds. {$request->addr_village}, Kec. {$request->addr_district}, Kab. {$request->addr_regency}, {$request->addr_postal}";

        // 4. Upload File
        $paymentPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentPath = $request->file('payment_proof')->store('payments', 'public');
        }

        $certPath = null;
        if ($request->hasFile('certificate_file')) {
            $certPath = $request->file('certificate_file')->store('certificates', 'public');
        }

        // 5. Simpan ke Database
        Registration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'school_origin' => $request->school_origin,
            'address' => $fullAddress,
            'payment_proof' => $paymentPath,
            'certificate_file' => $certPath,
            'status' => 'pending'
        ]);

        // 6. Redirect WA
        $sapaan = ($request->gender == 'L') ? 'Rekan' : 'Rekanita';
        $adminPhone = '628xxxxxxxxxx'; 
        
        $message = "Assalamu'alaikum, saya *$sapaan $request->name* telah mendaftar acara *{$event->title}*.\n\n"
                 . "Data diri dan persyaratan sudah saya upload. Mohon diverifikasi. Terima kasih.";
        
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