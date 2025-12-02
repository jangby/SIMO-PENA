<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\Profile;
use App\Models\Finance;
use App\Services\WahaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationApprovalController extends Controller
{
    /**
     * Helper: Cek apakah Admin berhak mengakses Data Pendaftaran ini
     */
    private function checkAccess(Registration $registration)
    {
        $user = Auth::user();
        
        // Jika Super Admin (PAC), boleh akses semua
        if ($user->organization_id == 1) {
            return true;
        }

        // Cek 1: Apakah event-nya milik organisasi admin ini?
        if ($registration->event && $registration->event->organization_id == $user->organization_id) {
            return true;
        }

        // Cek 2: Apakah pendaftaran ini tertuju langsung ke organisasi admin ini?
        if ($registration->organization_id == $user->organization_id) {
            return true;
        }

        // Jika tidak memenuhi syarat di atas, tolak akses
        abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin mengelola pendaftaran ini.');
    }

    /**
     * Tampilkan Daftar Pendaftaran (Pending) dengan Filter Organisasi
     */
    public function index()
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        // Eager load relasi biar hemat query
        $query = Registration::with(['event', 'user', 'organization'])
                             ->where('status', 'pending')
                             ->latest();

        // --- FILTER MULTI-ADMIN (Agar data tidak bercampur) ---
        if (!$isPac) {
            $orgId = $user->organization_id;
            
            $query->where(function($q) use ($orgId) {
                // A. Tampilkan jika Event-nya milik organisasi si Admin
                $q->whereHas('event', function($subQ) use ($orgId) {
                    $subQ->where('organization_id', $orgId);
                })
                // B. ATAU jika pendaftarannya langsung ditujukan ke organisasi si Admin
                ->orWhere('organization_id', $orgId);
            });
        }

        $registrations = $query->paginate(10);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        $this->checkAccess($registration);
        return view('admin.registrations.show', compact('registration'));
    }

    // --- FUNGSI APPROVE CERDAS ---
    public function approve(Registration $registration, WahaService $waha)
    {
        $this->checkAccess($registration); // Proteksi Akses

        // 1. CEK APAKAH USER SUDAH ADA? (Berdasarkan No HP di Profile)
        $existingProfile = Profile::where('phone', $registration->phone)->first();
        
        $user = null;
        $isNewAccount = false;
        $email = '';
        $password = '';

        // --- SKENARIO 1: USER LAMA (SUDAH PUNYA AKUN) ---
        if ($existingProfile) {
            $user = $existingProfile->user;
            $isNewAccount = false;

            $user->update(['is_active' => true]); 

            // Update Grade Saja (Naik Tingkat)
            // Jika dia daftar Lakmud, naik jadi Kader. Jika Makesta, tetap Anggota.
            $newGrade = $user->profile->grade; // Default grade lama
            
            if ($registration->event && $registration->event->type == 'lakmud') {
                $newGrade = 'kader';
            } elseif ($registration->event && $registration->event->type == 'makesta' && $newGrade == 'calon') {
                $newGrade = 'anggota';
            }

            $user->profile()->update([
                'grade' => $newGrade
                // Kita tidak update data lain (alamat/tgl lahir) agar data lama terjaga
            ]);
        } 
        
        // --- SKENARIO 2: USER BARU (BELUM PUNYA AKUN) ---
        else {
            $isNewAccount = true;

            // Generate Email Unik
            $cleanName = Str::slug($registration->name, ''); 
            $email = $cleanName . '@pena.limbangan';
            while (User::where('email', $email)->exists()) {
                $email = $cleanName . rand(1, 999) . '@pena.limbangan';
            }

            $password = '12345678'; 

            // Buat User
            $user = User::create([
                'name' => $registration->name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'member',
                'is_active' => true,
                // Assign User ke Organisasi Admin yang meng-approve (atau sesuai event)
                'organization_id' => $registration->organization_id ?? Auth::user()->organization_id,
            ]);

            // Tentukan Grade Awal
            $newGrade = 'calon';
            if ($registration->event) {
                if ($registration->event->type == 'makesta') $newGrade = 'anggota';
                elseif ($registration->event->type == 'lakmud') $newGrade = 'kader';
            }

            // Buat Profile Baru
            $user->profile()->create([
                'phone' => $registration->phone,
                'school_origin' => $registration->school_origin,
                'address' => $registration->address,
                'birth_place' => $registration->birth_place, // Pastikan kolom ini ada di tabel registrations
                'birth_date' => $registration->birth_date,   // Pastikan kolom ini ada di tabel registrations
                'gender' => $registration->gender,           // Pastikan kolom ini ada di tabel registrations
                'grade' => $newGrade,
                'nia_ipnu' => null, 
            ]);
            
            // Hubungkan registrasi ini ke user baru
            $registration->update(['user_id' => $user->id]);
        }

        // 2. UPDATE STATUS PENDAFTARAN (Menjadi Approved)
        $registration->update(['status' => 'approved']);

        // 3. CATAT KEUANGAN (Jika Berbayar & Event Ada)
        if ($registration->event && $registration->event->price > 0) {
            Finance::create([
                'type' => 'income',
                'amount' => $registration->event->price,
                'description' => "Pendaftaran Event: {$registration->event->title} a.n {$registration->name}",
                'date' => now(),
                'event_id' => $registration->event->id,
                // Uang masuk ke kas organisasi admin yang menyetujui
                'organization_id' => Auth::user()->organization_id, 
            ]);
        }

        // 4. SIAPKAN PESAN WA (BEDA ISI UNTUK LAMA VS BARU)
        $sapaan = ($registration->gender == 'P') ? 'Rekanita' : 'Rekan';
        $eventName = $registration->event ? $registration->event->title : 'Keanggotaan';
        
        $pesanHeader = "*PENDAFTARAN DITERIMA!* ✅\n\n"
                     . "Halo $sapaan *{$registration->name}*,\n"
                     . "Selamat! Pendaftaran Anda untuk acara *{$eventName}* telah disetujui oleh Admin.\n\n";

        if ($isNewAccount) {
            // PESAN UNTUK USER BARU (Kirim Akun)
            $pesanAkun = "Berikut Akun Login Aplikasi Anda:\n"
                       . "📧 Email: *$email*\n"
                       . "🔑 Password: *$password*\n\n"
                       . "Silakan login di: " . route('login') . "\n"
                       . "Simpan pesan ini baik-baik.";
        } else {
            // PESAN UNTUK USER LAMA (Pakai Akun Lama)
            $pesanAkun = "Karena Anda sudah terdaftar sebelumnya, silakan login menggunakan *Akun Lama Anda*.\n\n"
                       . "Link Login: " . route('login') . "\n"
                       . "Jika lupa password, silakan hubungi admin.";
        }

        $pesanFooter = "\n\nSalam Belajar, Berjuang, Bertakwa!";

        // Gabungkan Pesan
        $finalMessage = $pesanHeader . $pesanAkun . $pesanFooter;

        // Kirim WA (Try catch biar gak error kalau WA offline)
        try {
            $waha->sendText($registration->phone, $finalMessage);
        } catch (\Exception $e) {
            // Log error WA, tapi jangan batalkan approve
        }

        return redirect()->route('admin.registrations.index')
               ->with('success', 'Pendaftaran Disetujui. ' . ($isNewAccount ? 'Akun Baru Dibuat.' : 'Menggunakan Akun Lama.'));
    }

    // --- FUNGSI TOLAK ---
    public function reject(Request $request, Registration $registration, WahaService $waha)
    {
        $this->checkAccess($registration); // Proteksi Akses

        $request->validate(['reason' => 'required|string|max:255']);
        $registration->update(['status' => 'rejected']); 

        $sapaan = ($registration->gender == 'P') ? 'Rekanita' : 'Rekan';
        $eventName = $registration->event ? $registration->event->title : 'Event';
        
        $pesanWA = "*MOHON MAAF, PENDAFTARAN DITOLAK* ❌\n\n"
                 . "Halo $sapaan *{$registration->name}*,\n"
                 . "Pendaftaran Anda untuk acara *{$eventName}* belum dapat kami setujui.\n\n"
                 . "⚠️ *Alasan Penolakan:*\n"
                 . "_{$request->reason}_\n\n"
                 . "Silakan perbaiki data/persyaratan dan daftar kembali.\n"
                 . "- Panitia Pelaksana";

        try {
            $waha->sendText($registration->phone, $pesanWA);
        } catch (\Exception $e) {
            // Ignore error
        }

        return redirect()->route('admin.registrations.index')->with('success', 'Pendaftaran Ditolak.');
    }
}