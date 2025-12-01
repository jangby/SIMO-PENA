<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;

class MyEventController extends Controller
{
    // 1. Daftar Kegiatan yang Diikuti
    public function index()
    {
        $user = Auth::user();
        
        // Cari pendaftaran berdasarkan Nomor HP user (karena saat daftar belum login)
        // Asumsi: Profile user sudah diisi dan punya no HP
        $myEvents = Registration::with('event')
                    ->where('phone', $user->profile->phone ?? '')
                    ->latest()
                    ->get();

        return view('member.my-events.index', compact('myEvents'));
    }

    // 2. Dashboard Detail Kegiatan (Manajemen Peserta)
    public function show($id)
    {
        $registration = Registration::with(['event', 'event.schedules'])->findOrFail($id);
        
        // Pastikan yang akses adalah pemilik data (Validasi sederhana by Phone)
        if ($registration->phone != Auth::user()->profile->phone) {
            abort(403, 'Akses Ditolak');
        }

        return view('member.my-events.show', compact('registration'));
    }

    // 3. Tampilan ID Card (Siap Print/Screenshot)
    public function idCard($id)
    {
        $registration = Registration::with('event')->findOrFail($id);
        
        // 1. Generate Barcode (Code 128 standard)
        $generator = new BarcodeGeneratorPNG();
        // Kita gunakan ID Pendaftaran sebagai isi barcode
        $barcodeData = $generator->getBarcode($registration->id, $generator::TYPE_CODE_128);
        
        // Encode ke Base64 agar bisa tampil di img src
        $barcodeBase64 = base64_encode($barcodeData);

        return view('member.my-events.id-card', compact('registration', 'barcodeBase64'));
    }
}