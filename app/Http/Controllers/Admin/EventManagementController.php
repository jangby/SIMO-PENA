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

class EventManagementController extends Controller
{
    // --- HALAMAN 1: DATA PESERTA ---
    public function participants(Event $event)
    {
        // Ambil peserta yang statusnya approved saja
        $participants = $event->registrations()
                        ->where('status', 'approved')
                        ->latest()
                        ->get();
        return view('admin.events.participants', compact('event', 'participants'));
    }

    // --- HALAMAN 2: JADWAL / RUNDOWN ---
    public function schedules(Event $event)
    {
        // Urutkan jadwal berdasarkan jam mulai
        $schedules = $event->schedules()->orderBy('start_time')->get();
        return view('admin.events.schedules', compact('event', 'schedules'));
    }

    public function storeSchedule(Request $request, Event $event)
    {
        $request->validate([
            'start_time' => 'required',
            'end_time' => 'required',
            'activity' => 'required|string',
            'pic' => 'nullable|string',
        ]);

        $event->schedules()->create($request->all());
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function destroySchedule(EventSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Sesi dihapus.');
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
    public function scanQr(Request $request, Event $event)
    {
        // 1. Validasi Input (ID Pendaftaran)
        $registrationId = $request->registration_id;
        
        $registration = Registration::find($registrationId);

        // 2. Cek apakah data ada?
        if (!$registration) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data QR Code tidak valid / tidak ditemukan.'
            ], 404);
        }

        // 3. Cek apakah QR ini milik Event yang sedang dibuka?
        if ($registration->event_id != $event->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Peserta ini terdaftar untuk event lain, bukan event ini.'
            ], 400);
        }

        // 4. Cek apakah statusnya Approved?
        if ($registration->status != 'approved') {
            return response()->json([
                'status' => 'error',
                'message' => 'Peserta ini belum lunas/disetujui admin.'
            ], 400);
        }

        // 5. Cek apakah sudah absen sebelumnya?
        if ($registration->presence_at) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Peserta atas nama ' . $registration->name . ' SUDAH absen sebelumnya.'
            ]);
        }

        // 6. SUKSES: Catat Kehadiran
        $registration->update(['presence_at' => now()]);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil! ' . $registration->name . ' telah hadir.',
            'user_name' => $registration->name,
            'time' => now()->format('H:i')
        ]);
    }

    public function exportExcel(Event $event)
{
    return Excel::download(new EventParticipantsExport($event->id), 'peserta-'.$event->id.'.xlsx');
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
}