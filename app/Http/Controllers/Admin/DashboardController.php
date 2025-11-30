<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Kartu Atas
        $totalKader = User::where('role', 'member')->count();
        $pendingRequests = Registration::where('status', 'pending')->count();
        $activeEvents = Event::where('status', 'open')->count();
        $totalEvents = Event::count();

        // 2. Daftar 5 Kader Terbaru
        $latestMembers = User::where('role', 'member')
                        ->with('profile')
                        ->latest()
                        ->take(5)
                        ->get();

        // 3. Kegiatan yang akan datang (Rapat/Makesta terdekat)
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