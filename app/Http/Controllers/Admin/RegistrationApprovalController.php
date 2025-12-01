<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\Profile;
use App\Models\Finance;
use App\Services\WahaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationApprovalController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('event')
                        ->where('status', 'pending')
                        ->latest()
                        ->paginate(10);
                        
        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    // --- FUNGSI APPROVE CERDAS ---
    public function approve(Registration $registration, WahaService $waha)
    {
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

            $user->update(['is_active' => true]); // <--- Tambahkan ini

            // Update Grade Saja (Naik Tingkat)
            // Jika dia daftar Lakmud, naik jadi Kader. Jika Makesta, tetap Anggota.
            $newGrade = $user->profile->grade; // Default grade lama
            if ($registration->event->type == 'lakmud') {
                $newGrade = 'kader';
            } elseif ($registration->event->type == 'makesta' && $newGrade == 'calon') {
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
            ]);

            // Tentukan Grade Awal
            $newGrade = 'calon';
            if ($registration->event->type == 'makesta') $newGrade = 'anggota';
            elseif ($registration->event->type == 'lakmud') $newGrade = 'kader';

            // Buat Profile Baru
            $user->profile()->create([
                'phone' => $registration->phone,
                'school_origin' => $registration->school_origin,
                'address' => $registration->address,
                'birth_place' => $registration->birth_place,
                'birth_date' => $registration->birth_date,
                'gender' => $registration->gender,
                'grade' => $newGrade,
                'nia_ipnu' => null, 
            ]);
        }

        // 2. UPDATE STATUS PENDAFTARAN (Menjadi Approved)
        $registration->update(['status' => 'approved']);

        // 3. CATAT KEUANGAN (Jika Berbayar)
        if ($registration->event->price > 0) {
            Finance::create([
                'type' => 'income',
                'amount' => $registration->event->price,
                'description' => "Pendaftaran Event: {$registration->event->title} a.n {$registration->name}",
                'date' => now(),
                'event_id' => $registration->event->id,
            ]);
        }

        // 4. SIAPKAN PESAN WA (BEDA ISI UNTUK LAMA VS BARU)
        $sapaan = ($registration->gender == 'P') ? 'Rekanita' : 'Rekan';
        
        $pesanHeader = "*PENDAFTARAN DITERIMA!* ✅\n\n"
                     . "Halo $sapaan *{$registration->name}*,\n"
                     . "Selamat! Pendaftaran Anda untuk acara *{$registration->event->title}* telah disetujui oleh Admin.\n\n";

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

        $pesanFooter = "\nSalam Belajar, Berjuang, Bertakwa!";

        // Gabungkan Pesan
        $finalMessage = $pesanHeader . $pesanAkun . $pesanFooter;

        // Kirim WA
        $waha->sendText($registration->phone, $finalMessage);

        return redirect()->route('admin.registrations.index')
               ->with('success', 'Pendaftaran Disetujui. ' . ($isNewAccount ? 'Akun Baru Dibuat.' : 'Menggunakan Akun Lama.'));
    }

    // --- FUNGSI TOLAK ---
    public function reject(Request $request, Registration $registration, WahaService $waha)
    {
        $request->validate(['reason' => 'required|string|max:255']);
        $registration->update(['status' => 'rejected']); 

        $sapaan = ($registration->gender == 'P') ? 'Rekanita' : 'Rekan';
        
        $pesanWA = "*MOHON MAAF, PENDAFTARAN DITOLAK* ❌\n\n"
                 . "Halo $sapaan *{$registration->name}*,\n"
                 . "Pendaftaran Anda untuk acara *{$registration->event->title}* belum dapat kami setujui.\n\n"
                 . "⚠️ *Alasan Penolakan:*\n"
                 . "_{$request->reason}_\n\n"
                 . "Silakan perbaiki data/persyaratan dan daftar kembali.\n"
                 . "- Panitia Pelaksana";

        $waha->sendText($registration->phone, $pesanWA);

        return redirect()->route('admin.registrations.index')->with('success', 'Pendaftaran Ditolak.');
    }
}