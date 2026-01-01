<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Exports\EventParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Picqer\Barcode\BarcodeGeneratorPNG;
use App\Models\User;    
use App\Models\Profile;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Services\WahaService;

class EventManagementController extends Controller
{

    // TAMPILKAN JADWAL (DIKELOMPOKKAN PER HARI)
    public function schedules(Event $event)
    {
        // Ambil semua jadwal, urutkan berdasarkan waktu mulai
        $rawSchedules = $event->schedules()->orderBy('start_time')->get();

        // Grouping berdasarkan Tanggal (Y-m-d)
        // Hasilnya: ['2025-01-01' => [sesi1, sesi2], '2025-01-02' => [sesi3]]
        $groupedSchedules = $rawSchedules->groupBy(function($item) {
            return $item->start_time->format('Y-m-d');
        });

        return view('admin.events.schedules', compact('event', 'groupedSchedules'));
    }

    // SIMPAN JADWAL (MERGE TANGGAL + JAM)
    public function storeSchedule(Request $request, Event $event)
    {
        $request->validate([
            'schedule_date' => 'required|date', // Input Tanggal
            'start_time' => 'required',         // Input Jam Mulai
            'end_time' => 'required',           // Input Jam Selesai
            'activity' => 'required|string',
            'pic' => 'nullable|string',
        ]);

        // Gabungkan Tanggal + Jam
        // Contoh: "2025-01-01" + "08:00" = "2025-01-01 08:00:00"
        $startDateTime = $request->schedule_date . ' ' . $request->start_time;
        $endDateTime = $request->schedule_date . ' ' . $request->end_time;

        $event->schedules()->create([
            'start_time' => $startDateTime,
            'end_time' => $endDateTime,
            'activity' => $request->activity,
            'pic' => $request->pic,
        ]);

        return back()->with('success', 'Sesi berhasil ditambahkan.');
    }

    // PERBAIKAN: Tambahkan (Event $event) di parameter pertama
    public function destroySchedule(Event $event, EventSchedule $schedule)
    {
        // Hapus jadwal
        $schedule->delete();
        
        return back()->with('success', 'Sesi berhasil dihapus.');
    }

    // --- HALAMAN 3: ABSENSI ---
    public function attendance(Event $event)
    {
        $participants = $event->registrations()
                        ->where('status', 'approved')
                        ->orderBy('name')
                        ->get();
        return view('admin.events.attendance', compact('event', 'participants'));
    }

    // Proses Check-in (Manual Tombol)
    public function checkIn(Event $event, Registration $registration)
    {
        $registration->update(['presence_at' => now()]);
        return back()->with('success', $registration->name . ' berhasil check-in.');
    }
    
    // Ini juga diperbaiki
    public function cancelCheckIn(Event $event, Registration $registration)
    {
        $registration->update(['presence_at' => null]);
        return back()->with('success', 'Absensi dibatalkan.');
    }

    // --- FITUR SCAN QR (AJAX) ---
    public function scanQr(Request $request)
    {
        $request->validate([
            'qrcode' => 'required',
            'mode' => 'required',
            'event_id' => 'required' // Pastikan event_id dikirim dari frontend
        ]);

        $qrContent = $request->qrcode;
        $eventId = $request->event_id;

        // --- LOGIKA PENCARIAN CERDAS ---
        
        // OPSI 1: Coba cari anggap QR Code adalah 'Registration ID' (Default Sistem)
        $registration = Registration::where('id', $qrContent)
                                    ->where('event_id', $eventId) // Pastikan milik event ini
                                    ->first();

        // OPSI 2: Jika tidak ketemu, cari anggap QR Code adalah 'User ID' (Sesuai kasus kamu)
        if (!$registration) {
            $registration = Registration::where('user_id', $qrContent)
                                        ->where('event_id', $eventId)
                                        ->first();
        }

        // --- VALIDASI HASIL ---

        // 1. Jika data tetap tidak ditemukan
        if (!$registration) {
            return response()->json([
                'message' => 'Data peserta tidak ditemukan di event ini.'
            ], 404);
        }

        // 2. Jika status belum disetujui
        if ($registration->status !== 'approved') {
            return response()->json([
                'message' => 'Status pendaftaran peserta belum disetujui.'
            ], 400);
        }

        // --- PROSES ABSENSI ---

        if ($request->mode === 'checkin') {
            // MODE: DAFTAR ULANG
            if ($registration->presence_at) {
                return response()->json(['message' => 'Peserta sudah check-in sebelumnya.'], 400);
            }
            
            $registration->update(['presence_at' => now()]);
            
            return response()->json([
                'status' => 'success',
                'name' => $registration->name,
                'school' => $registration->school_origin,
                'type' => 'Daftar Ulang'
            ]);

        } else {
            // MODE: ABSENSI MATERI
            $scheduleId = $request->mode;
            
            // Cek apakah jadwal ini benar milik event ini (Validasi keamanan)
            $validSchedule = \App\Models\EventSchedule::where('id', $scheduleId)
                                ->where('event_id', $eventId)
                                ->exists();
                                
            if(!$validSchedule) {
                return response()->json(['message' => 'Jadwal tidak valid untuk event ini.'], 400);
            }

            // Cek duplikasi absen materi
            $exists = \App\Models\ScheduleAttendance::where('registration_id', $registration->id)
                        ->where('event_schedule_id', $scheduleId)
                        ->exists();

            if ($exists) {
                return response()->json(['message' => 'Peserta sudah absen di sesi ini.'], 400);
            }

            \App\Models\ScheduleAttendance::create([
                'registration_id' => $registration->id,
                'event_schedule_id' => $scheduleId,
                'scanned_at' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'name' => $registration->name,
                'school' => $registration->school_origin,
                'type' => 'Materi'
            ]);
        }
    }

    // --- HALAMAN 1: DATA PESERTA (UPDATE FILTER) ---
    public function participants(Request $request, Event $event)
    {
        // Mulai Query
        $query = $event->registrations()
                       ->where('status', 'approved');

        // Filter: Jika ada request 'gender' (L/P)
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        $participants = $query->latest()->get();

        return view('admin.events.participants', compact('event', 'participants'));
    }

    // --- EXPORT EXCEL (UPDATE FILTER) ---
    public function exportExcel(Request $request, Event $event)
    {
        // Ambil filter dari request (dikirim dari Modal)
        $gender = $request->query('gender'); // Bisa null, 'L', atau 'P'
        
        // Buat nama file yang dinamis
        $label = 'Semua';
        if ($gender == 'L') $label = 'IPNU';
        if ($gender == 'P') $label = 'IPPNU';

        $fileName = 'Peserta_' . $label . '_' . $event->title . '.xlsx';

        // Panggil Export Class dengan parameter gender
        return Excel::download(new EventParticipantsExport($event->id, $gender), $fileName);
    }

public function printAllIdCards(Event $event)
    {
        // 1. Ambil semua peserta yang APPROVED
        $participants = $event->registrations()
                        ->with('event') // Eager load event
                        ->where('status', 'approved')
                        ->get();

        if ($participants->isEmpty()) {
            return back()->with('error', 'Belum ada peserta yang disetujui.');
        }

        // 2. Generate Barcode untuk setiap peserta (Looping di Controller biar View bersih)
        $generator = new BarcodeGeneratorPNG();
        foreach ($participants as $p) {
            // Simpan barcode base64 sementara di objek peserta
            $p->barcode = base64_encode($generator->getBarcode($p->id, $generator::TYPE_CODE_128));
            
            // Ambil foto profil (Path absolut agar terbaca DOMPDF)
            // Jika pakai storage link, gunakan public_path()
            $user = User::where('email', $p->email)->first(); // Cari user terkait (jika ada relasi langsung lebih baik)
            // NOTE: Di sistem kita relasi registration ke user agak loose (by phone/email).
            // Sebaiknya kita cari user berdasarkan no HP yang sama
            $userProfile = \App\Models\Profile::where('phone', $p->phone)->first();
            
            if ($userProfile && $userProfile->photo) {
                $p->photo_path = public_path('storage/' . $userProfile->photo);
            } else {
                $p->photo_path = null; // Nanti pakai placeholder
            }
        }

        // 3. Load View PDF
        $pdf = Pdf::loadView('admin.events.pdf_idcards', compact('event', 'participants'))
                  ->setPaper('a4', 'portrait'); // A4 Tegak

        // 4. Download / Stream PDF
        return $pdf->stream('ID_Cards_' . $event->title . '.pdf');
    }

    // --- HALAMAN KELOLA SERTIFIKAT (List Peserta) ---
    public function certificates(Event $event)
    {
        // Hanya tampilkan peserta yang SUDAH HADIR (presence_at tidak null)
        // Karena logikanya sertifikat hanya untuk yang hadir
        $participants = $event->registrations()
                        ->whereNotNull('presence_at') 
                        ->latest()
                        ->get();

        return view('admin.events.certificates', compact('event', 'participants'));
    }

    // PERBAIKAN: Tambahkan (Event $event) sebelum Registration
    public function storeCertificate(Request $request, Event $event, Registration $registration)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        // Hapus file lama jika ada
        if ($registration->certificate_file) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $registration->certificate_file);
        }

        // Simpan File
        $fileName = 'CERT_' . time() . '_' . $registration->id . '.' . $request->file->extension();
        $path = $request->file('file')->storeAs('certificates', $fileName, 'public');

        // Update Database
        $registration->update(['certificate_file' => $path]);

        return back()->with('success', 'Sertifikat untuk ' . $registration->name . ' berhasil diupload.');
    }

    // --- HALAMAN 4: LIHAT QR CODE & DATA ---
    public function showQrCodes(Request $request, Event $event)
    {
        // 1. Mulai Query
        $query = $event->registrations()
                        ->where('status', 'approved')
                        ->orderBy('name');

        // 2. Cek Filter Gender
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // 3. Eksekusi
        $participants = $query->get();

        return view('admin.events.qr_codes', compact('event', 'participants'));
    }

    // --- AKSI DOWNLOAD QR CODE (PNG) ---
    public function downloadQrCode(Event $event, Registration $registration)
    {
        $content = $registration->id; 

        // UBAH DI SINI: Ganti 'png' jadi 'svg'
        // SVG tidak butuh Imagick, dan hasilnya lebih tajam (vektor)
        $qrCode = QrCode::format('svg')->size(500)->margin(1)->generate($content);

        $safeName = preg_replace('/[^A-Za-z0-9 ]/', '', $registration->name);
        $safeDelegation = preg_replace('/[^A-Za-z0-9 ]/', '', $registration->school_origin);
        
        // Ganti ekstensi nama file jadi .svg
        $fileName = "{$safeName} - {$safeDelegation}.svg";

        return response($qrCode)
            ->header('Content-Type', 'image/svg+xml') // Header untuk SVG
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function storeParticipant(Request $request, Event $event)
    {
        // 1. Validasi Input
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'required|numeric',
            'gender'        => 'required|in:L,P',
            'birth_place'   => 'required|string',
            'birth_date'    => 'required|date',
            'school_origin' => 'required|string',
            'address'       => 'required|string',
        ]);

        return DB::transaction(function () use ($request, $event) {
            // A. Cek / Buat User & Profile
            $user = User::where('email', $request->email)->first();
            $generatedPassword = null;
            $isNewUser = false;

            if (!$user) {
                // User Baru
                $isNewUser = true;
                $generatedPassword = Str::random(8); 

                $user = User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => Hash::make($generatedPassword),
                    'role'      => 'member',
                    'is_active' => true,
                ]);

                // Profile Baru
                $user->profile()->create([
                    'phone'       => $request->phone,
                    'gender'      => $request->gender,
                    'birth_place' => $request->birth_place,
                    'birth_date'  => $request->birth_date,
                    'grade'       => 'calon',
                ]);
            } else {
                // User Lama: Update Profile
                $user->profile()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'phone'       => $request->phone,
                        'gender'      => $request->gender,
                        'birth_place' => $request->birth_place,
                        'birth_date'  => $request->birth_date,
                    ]
                );
            }

            // B. Cek Duplikat
            $existingRegistration = Registration::where('user_id', $user->id)
                                    ->where('event_id', $event->id)
                                    ->first();

            if ($existingRegistration) {
                return back()->with('error', 'Peserta dengan email ini sudah terdaftar.');
            }

            // C. Simpan Pendaftaran
            Registration::create([
                'event_id'       => $event->id,
                'user_id'        => $user->id,
                'name'           => $request->name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'gender'         => $request->gender,
                'birth_place'    => $request->birth_place,
                'birth_date'     => $request->birth_date,
                'school_origin'  => $request->school_origin,
                'address'        => $request->address,
                'status'         => 'approved',
                'payment_status' => 'paid',
                'payment_proof'  => 'OFFLINE_CASH',
            ]);

            // D. Kirim Notifikasi WhatsApp (YANG LEBIH BAGUS)
            try {
                $waha = new WahaService();
                $sapaan = ($request->gender == 'L') ? 'Rekan' : 'Rekanita';
                $loginUrl = route('login'); // Otomatis ambil link login
                
                if ($isNewUser) {
                    // --- PESAN UNTUK PENGGUNA BARU ---
                    $msg  = "*PENDAFTARAN OFFLINE BERHASIL* ✅\n\n";
                    $msg .= "Halo $sapaan *{$request->name}*,\n";
                    $msg .= "Admin telah mendaftarkan Anda secara manual pada kegiatan:\n\n";
                    $msg .= "📅 *{$event->title}*\n";
                    $msg .= "📍 {$event->location}\n\n";
                    $msg .= "Berikut adalah akses akun Anda untuk masuk ke sistem:\n";
                    $msg .= "----------------------------------\n";
                    $msg .= "🔗 *Login:* $loginUrl\n";
                    $msg .= "📧 *Email:* {$request->email}\n";
                    $msg .= "🔑 *Password:* {$generatedPassword}\n";
                    $msg .= "----------------------------------\n\n";
                    $msg .= "⚠️ *PENTING:*\n";
                    $msg .= "Demi keamanan, mohon *SEGERA GANTI PASSWORD* Anda setelah berhasil login melalui menu Profil.\n\n";
                    $msg .= "Tiket & ID Card dapat diminta ke Panitia.\n\n";
                    $msg .= "_Terima Kasih,_ \n*Panitia Pelaksana*";
                    
                    $waha->sendText($request->phone, $msg);
                } else {
                    // --- PESAN UNTUK PENGGUNA LAMA ---
                    $msg  = "*PENDAFTARAN OFFLINE BERHASIL* ✅\n\n";
                    $msg .= "Halo $sapaan *{$request->name}*,\n";
                    $msg .= "Pendaftaran susulan (manual) Anda berhasil diproses oleh Admin untuk kegiatan:\n\n";
                    $msg .= "📅 *{$event->title}*\n";
                    $msg .= "📍 {$event->location}\n\n";
                    $msg .= "Silakan login untuk melihat tiket dan jadwal terbaru.\n\n";
                    $msg .= "🔗 *Akses:* $loginUrl\n\n";
                    $msg .= "_Terima Kasih,_ \n*Panitia Pelaksana*";
                    
                    $waha->sendText($request->phone, $msg);
                }
            } catch (\Exception $e) {
                // Error WA diabaikan agar data tetap tersimpan
            }

            return back()->with('success', 'Peserta Offline berhasil didaftarkan & Notifikasi dikirim!');
        });
    }
}