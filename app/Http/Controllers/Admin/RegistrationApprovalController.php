<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Models\Finance; // Jangan lupa import ini
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

    // --- FUNGSI UTAMA APPROVE (LENGKAP) ---
    public function approve(Registration $registration, WahaService $waha)
    {
        // 1. GENERATE EMAIL UNIK (nama@pena.limbangan)
        $cleanName = Str::slug($registration->name, ''); 
        $email = $cleanName . '@pena.limbangan';
        
        // Cek duplikat email, jika ada tambah angka acak
        while (User::where('email', $email)->exists()) {
            $email = $cleanName . rand(1, 999) . '@pena.limbangan';
        }

        $password = '12345678'; // Password Default

        // 2. BUAT USER BARU
        // Kita gunakan firstOrCreate untuk jaga-jaga jika user daftar event kedua kalinya
        // Tapi logic email di atas sebenarnya sudah handle untuk user baru
        $user = User::create([
            'name' => $registration->name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'member',
        ]);

        // 3. TENTUKAN GRADE (Tingkatan Kaderisasi)
        $newGrade = 'calon'; // Default
        if ($registration->event->type == 'makesta') {
            $newGrade = 'anggota';
        } elseif ($registration->event->type == 'lakmud') {
            $newGrade = 'kader';
        }

        // 4. BUAT / UPDATE PROFILE
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $registration->phone,
                'school_origin' => $registration->school_origin,
                'address' => $registration->address,
                'birth_place' => $registration->birth_place,
                'birth_date' => $registration->birth_date,
                'gender' => 'L', // Default, nanti diedit user
                'grade' => $newGrade, // <--- Update Tingkatan
                'nia_ipnu' => null, 
            ]
        );

        // 5. UPDATE STATUS PENDAFTARAN
        $registration->update(['status' => 'approved']);

        // 6. CATAT KEUANGAN (Jika Berbayar)
        if ($registration->event->price > 0) {
            Finance::create([
                'type' => 'income', // Pemasukan
                'amount' => $registration->event->price,
                'description' => "Pendaftaran Event: {$registration->event->title} a.n {$registration->name}",
                'date' => now(),
                'event_id' => $registration->event->id,
            ]);
        }

        // 7. KIRIM NOTIFIKASI WA
        $pesanWA = "*PENDAFTARAN DITERIMA!* ✅\n\n"
                 . "Halo rekan *{$registration->name}*,\n"
                 . "Selamat! Pendaftaran Anda untuk acara *{$registration->event->title}* telah disetujui.\n\n"
                 . "Akun Login Aplikasi:\n"
                 . "📧 Email: *$email*\n"
                 . "🔑 Password: *$password*\n\n"
                 . "Silakan login di: " . route('login') . "\n"
                 . "Simpan pesan ini baik-baik. Salam Belajar, Berjuang, Bertakwa!";

        // Panggil Service WAHA
        // Pastikan WAHA sudah jalan & API Key benar di .env
        $terkirim = $waha->sendText($registration->phone, $pesanWA);

        $statusMsg = $terkirim ? "Akun dibuat, Keuangan dicatat & WA Terkirim." : "Akun dibuat, Keuangan dicatat, TAPI Gagal kirim WA.";

        return redirect()->route('admin.registrations.index')
               ->with('success', $statusMsg);
    }
}