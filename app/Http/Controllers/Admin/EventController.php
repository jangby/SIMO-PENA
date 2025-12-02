<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Helper Cek Akses
    private function checkAccess(Event $event) {
        $user = Auth::user();
        if ($user->organization_id != 1 && $event->organization_id != $user->organization_id) {
            abort(403, 'Akses Ditolak: Anda tidak berhak mengelola event ini.');
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $query = Event::withCount('registrations')->latest();

        // --- FILTER ---
        if (!$isPac) {
            $query->where('organization_id', $user->organization_id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'type' => 'required|in:makesta,lakmud,rapat,lainnya',
            'banner' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric',
            'bank_accounts' => 'nullable|array',
        ]);

        $data = $request->all();
        $data['organization_id'] = Auth::user()->organization_id; // Simpan Pemilik Event
        $data['status'] = 'open';

        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        $this->checkAccess($event);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->checkAccess($event);

        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required',
            'type' => 'required',
            'banner' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('banner')) {
            if ($event->banner) Storage::delete('public/' . $event->banner);
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $event->update($data);
        return redirect()->route('admin.events.index')->with('success', 'Data kegiatan diperbarui.');
    }

    public function destroy(Event $event)
    {
        $this->checkAccess($event);

        if ($event->banner) {
            Storage::delete('public/' . $event->banner);
        }
        $event->delete();
        return redirect()->back()->with('success', 'Kegiatan dihapus.');
    }

    public function manage(Event $event)
    {
        $this->checkAccess($event);

        $stats = [
            'total' => $event->registrations()->count(),
            'approved' => $event->registrations()->where('status', 'approved')->count(),
            'pending' => $event->registrations()->where('status', 'pending')->count(),
        ];

        return view('admin.events.manage', compact('event', 'stats'));
    }

    public function updateStatus(Request $request, Event $event)
    {
        $this->checkAccess($event);
        
        $request->validate(['status' => 'required|in:open,closed,draft']);
        $event->update(['status' => $request->status]);

        return back()->with('success', 'Status kegiatan diperbarui.');
    }
}