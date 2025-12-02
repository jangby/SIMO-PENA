<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Asumsi ID 1 adalah PAC (Pusat), jika user dari PAC maka $isPac = true
        $isPac = $user->organization_id == 1;

        // 1. STATISTIK KADER (Sesuai Organisasi)
        $kaderQuery = User::where('role', 'member');
        if (!$isPac) {
            // Filter hanya tampilkan kader dari organisasi admin yang login
            $kaderQuery->where('organization_id', $user->organization_id);
        }
        $totalKader = $kaderQuery->count();

        // 2. STATISTIK PERMOHONAN REGISTRASI (Sesuai Organisasi)
        $regQuery = Registration::where('status', 'pending');
        if (!$isPac) {
            // Filter pendaftar yang mendaftar ke organisasi ini
            $regQuery->where('organization_id', $user->organization_id);
        }
        $pendingRequests = $regQuery->count();

        // 3. STATISTIK EVENT 
        // (Sementara dibuat Global / Semua admin bisa lihat jumlah event)
        $activeEvents = Event::where('status', 'open')->count();
        $totalEvents = Event::count();

        // 4. DAFTAR 5 KADER TERBARU
        $latestMembersQuery = User::where('role', 'member')->with('profile');
        if (!$isPac) {
            $latestMembersQuery->where('organization_id', $user->organization_id);
        }
        $latestMembers = $latestMembersQuery->latest()->take(5)->get();

        // 5. KEGIATAN YANG AKAN DATANG (Global)
        $upcomingEvents = Event::where('start_time', '>=', now())
                        ->orderBy('start_time', 'asc')
                        ->take(3)
                        ->get();

        return view('admin.dashboard', compact(
            'totalKader', 'pendingRequests', 'activeEvents', 'totalEvents',
            'latestMembers', 'upcomingEvents'
        ));
    }
}