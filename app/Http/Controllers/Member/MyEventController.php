<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $registration = Registration::with('event')->findOrFail($id);

        // Validasi Pemilik
        if ($registration->phone != Auth::user()->profile->phone) {
            abort(403, 'Akses Ditolak');
        }

        // 1. AMBIL & GRUPKAN JADWAL PER TANGGAL
        // Hasil: ['2025-01-01' => [sesi1, sesi2], '2025-01-02' => [sesi3]]
        $groupedSchedules = $registration->event->schedules()
                            ->orderBy('start_time')
                            ->get()
                            ->groupBy(function($item) {
                                return $item->start_time->format('Y-m-d');
                            });

        // 2. GENERATE QR
        $qrcode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)
                    ->color(131, 33, 143)
                    ->margin(2)
                    ->generate($registration->id);

        return view('member.my-events.show', compact('registration', 'qrcode', 'groupedSchedules'));
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

    public function downloadCertificate($id)
    {
        $registration = Registration::with('event')->findOrFail($id);

        // Validasi Kepemilikan
        if ($registration->phone != Auth::user()->profile->phone) {
            abort(403, 'Akses Ditolak');
        }

        // Cek apakah file ada
        if (!$registration->certificate_file || !Storage::disk('public')->exists($registration->certificate_file)) {
            return back()->with('error', 'File sertifikat tidak ditemukan.');
        }

        // Buat Nama File Cantik untuk didownload user
        // Contoh: Sertifikat - Makesta Raya - Ahmad.pdf
        $cleanEventName = Str::slug($registration->event->title);
        $cleanUserName = Str::slug($registration->name);
        $downloadName = "Sertifikat-{$cleanEventName}-{$cleanUserName}.pdf";

        // Perintah Download
        return Storage::disk('public')->download($registration->certificate_file, $downloadName);
    }
}