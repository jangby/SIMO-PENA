<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\User;
use App\Services\WahaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegistrationApprovalController extends Controller
{
    // Tampilkan List
    public function index()
    {
        $registrations = Registration::with('event')
                        ->where('status', 'pending')
                        ->latest()
                        ->paginate(10);
                        
        return view('admin.registrations.index', compact('registrations'));
    }

    // Tampilkan Detail
    public function show(Registration $registration)
    {
        return view('admin.registrations.show', compact('registration'));
    }

    // FUNGSI APPROVE (YANG SUDAH DIPERBAIKI)
    public function approve(Registration $registration, WahaService $waha)
    {
        // 1. Generate Email Unik
        $cleanName = Str::slug($registration->name, ''); 
        $email = $cleanName . '@pena.limbangan';
        
        while (User::where('email', $email)->exists()) {
            $email = $cleanName . rand(1, 999) . '@pena.limbangan';
        }

        $password = '12345678';

        // 2. Buat User Baru
        $user = User::create([
            'name' => $registration->name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'member',
        ]);

        // 3. Buat Profile (FIX Tanggal Lahir)
        $user->profile()->create([
            'phone' => $registration->phone,
            'school_origin' => $registration->school_origin,
            'address' => $registration->address,
            'birth_date' => $registration->birth_date, // <--- Mengambil tanggal input user
            'gender' => 'L', // Default, bisa diubah member nanti
            'nia_ipnu' => null, 
        ]);

        // 4. Update Status Pendaftaran
        $registration->update(['status' => 'approved']);

        // 5. Kirim WA Notifikasi
        $pesanWA = "*PENDAFTARAN DITERIMA!* ✅\n\n"
                 . "Halo rekan *{$registration->name}*,\n"
                 . "Selamat! Pendaftaran Anda untuk acara *{$registration->event->title}* telah disetujui.\n\n"
                 . "Akun Login Aplikasi:\n"
                 . "📧 Email: *$email*\n"
                 . "🔑 Password: *$password*\n\n"
                 . "Silakan login di: " . route('login') . "\n"
                 . "Salam Belajar, Berjuang, Bertakwa!";

        $terkirim = $waha->sendText($registration->phone, $pesanWA);

        $statusMsg = $terkirim ? "Akun dibuat & Notifikasi WA Terkirim." : "Akun dibuat, Gagal kirim WA.";

        return redirect()->route('admin.registrations.index')
               ->with('success', $statusMsg);
    }
}