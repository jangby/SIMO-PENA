<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AttendanceController extends Controller
{
    // 1. Halaman Daftar Kegiatan (Untuk Absensi)
    public function index()
    {
        $user = Auth::user();
        
        // Ambil event yang diikuti user (Status Approved)
        // Karena hanya yang approved yang bisa absen
        $events = Registration::with('event')
                    ->where('phone', $user->profile->phone ?? '')
                    ->where('status', 'approved') 
                    ->latest()
                    ->get();

        return view('member.attendance.index', compact('events'));
    }

    // 2. Halaman Detail Absensi (QR + Rundown)
    public function show($id)
    {
        $registration = Registration::with(['event', 'event.schedules'])->findOrFail($id);

        // Validasi Pemilik
        if ($registration->phone != Auth::user()->profile->phone) {
            abort(403);
        }

        // Generate QR Code (Isinya ID Pendaftaran)
        $qrcode = QrCode::size(200)
                    ->color(131, 33, 143) // Warna Ungu (#83218F)
                    ->margin(2)
                    ->generate($registration->id);

        return view('member.attendance.show', compact('registration', 'qrcode'));
    }
}