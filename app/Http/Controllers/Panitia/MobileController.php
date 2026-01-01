<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\EventSchedule;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF Facade

class MobileController extends Controller
{
    public function index()
    {
        // Tampilkan Event Aktif (Open/Closed)
        $activeEvents = Event::whereIn('status', ['open', 'closed'])->latest()->get();
        return view('panitia.dashboard', compact('activeEvents'));
    }

    public function exportPdf($id)
    {
        // Ambil SEMUA peserta yang approved (jangan di filter gender disini)
        $event = Event::with(['registrations' => function($q) {
            $q->where('status', 'approved')->orderBy('name');
        }, 'schedules'])->findOrFail($id);

        // Load View PDF
        $pdf = Pdf::loadView('panitia.events.pdf_recap', compact('event'));
        
        return $pdf->download('Rekap_Absensi_'.$event->title.'.pdf');
    }

    public function scan(Request $request)
    {
        // 1. Ambil ID Event dari URL (misal: ?event_id=1)
        $eventId = $request->query('event_id');
        
        // 2. Jika tidak ada ID, ambil semua event aktif (Jaga-jaga)
        if (!$eventId) {
            $events = Event::where('status', '!=', 'draft')->with('schedules')->get();
            return view('panitia.scan_general', compact('events'));
        }

        // 3. Ambil Event SPESIFIK beserta Rundown-nya (Diurutkan jam mulai)
        $event = Event::with(['schedules' => function($q) {
            $q->orderBy('start_time', 'asc');
        }])->findOrFail($eventId);

        return view('panitia.scan', compact('event'));
    }

    public function attendance(Request $request)
    {
        // 1. DATA UNTUK TAB 1: Daftar Ulang (Check-in Awal)
        $query = Registration::where('status', 'approved')->whereNotNull('presence_at');
        
        if ($request->has('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        $attendees = $query->latest('presence_at')->paginate(20);


        // 2. DATA UNTUK TAB 2: Per Materi
        $schedules = [];
        $allParticipants = collect();

        if ($request->has('event_id')) {
            $event = Event::with([
                'schedules.attendances.registration', // Load jadwal + data yang hadir
                'registrations' => function($q) {     // Load semua peserta approved
                    $q->where('status', 'approved')->orderBy('name');
                }
            ])->find($request->event_id);

            if ($event) {
                // Urutkan jadwal sesuai jam mulai
                $schedules = $event->schedules->sortBy('start_time');
                $allParticipants = $event->registrations;
            }
        }
        
        // Ambil list event untuk dropdown filter (jika ada)
        $events = Event::where('status', '!=', 'draft')->get();

        return view('panitia.attendance', compact('attendees', 'events', 'schedules', 'allParticipants'));
    }

    // Cetak PDF Khusus Satu Materi
    public function exportSchedulePdf($id)
    {
        // Ambil data jadwal beserta event dan semua pesertanya
        $schedule = EventSchedule::with(['event.registrations' => function($q) {
            $q->where('status', 'approved')->orderBy('name');
        }, 'attendances'])->findOrFail($id);

        // Load View PDF
        $pdf = Pdf::loadView('panitia.events.pdf_schedule', compact('schedule'));
        
        // Nama file aman
        $fileName = 'Absensi_' . preg_replace('/[^A-Za-z0-9]/', '_', $schedule->activity) . '.pdf';
        
        return $pdf->download($fileName);
    }

    public function show($id)
    {
        $event = Event::withCount([
            'registrations as total_participants' => function($q) {
                $q->where('status', 'approved');
            },
            'registrations as total_present' => function($q) {
                $q->where('status', 'approved')->whereNotNull('presence_at');
            }
        ])->findOrFail($id);

        // Ambil 5 orang yang barusan absen
        $recentPresences = Registration::where('event_id', $id)
            ->whereNotNull('presence_at')
            ->with('user.profile')
            ->orderBy('presence_at', 'desc')
            ->limit(5)
            ->get();

        return view('panitia.events.show', compact('event', 'recentPresences'));
    }

    // --- FITUR BARU: DAFTAR PESERTA (DENGAN FILTER GENDER) ---
    public function participants(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        // Base Query
        $query = $event->registrations()->where('status', 'approved');

        // 1. Filter Gender (IPNU/IPPNU)
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // 2. Fitur Pencarian Peserta
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Ambil Data
        $participants = $query->orderBy('name')->paginate(20);

        return view('panitia.events.participants', compact('event', 'participants'));
    }

    // --- FITUR BARU: RUNDOWN ACARA ---
    public function schedules($id)
    {
        $event = Event::findOrFail($id);
        // Urutkan jadwal berdasarkan waktu mulai
        $schedules = $event->schedules()->orderBy('start_time')->get();

        return view('panitia.events.schedules', compact('event', 'schedules'));
    }
}