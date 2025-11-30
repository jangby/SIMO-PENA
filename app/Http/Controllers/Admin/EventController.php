<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // 1. Tampilkan Daftar Event
    public function index()
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    // 2. Form Tambah Event
    public function create()
    {
        return view('admin.events.create');
    }

    // 3. Simpan Event Baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'type' => 'required|in:makesta,lakmud,rapat,lainnya',
            'banner' => 'nullable|image|max:2048', // Max 2MB
            'price' => 'nullable|numeric',
        ]);

        $data = $request->all();

        // Upload Banner
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        // Set default status 'open' saat dibuat
        $data['status'] = 'open';

        Event::create($data);

        return redirect()->route('admin.events.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    // 4. Hapus Event
    public function destroy(Event $event)
    {
        // Hapus gambar bannernya juga biar hemat storage
        if ($event->banner) {
            Storage::delete('public/' . $event->banner);
        }
        
        $event->delete();
        return redirect()->back()->with('success', 'Kegiatan dihapus.');
    }

    // --- TAMBAHAN BARU ---

    // 1. Halaman Edit
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // 2. Proses Update
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'location' => 'required',
            'type' => 'required',
            'banner' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Cek ganti banner
        if ($request->hasFile('banner')) {
            // Hapus banner lama
            if ($event->banner) Storage::delete('public/' . $event->banner);
            // Upload banner baru
            $data['banner'] = $request->file('banner')->store('banners', 'public');
        }

        $event->update($data);

        return redirect()->route('admin.events.index')->with('success', 'Data kegiatan diperbarui.');
    }

    // 3. Halaman DASHBOARD KEGIATAN (Command Center)
    public function manage(Event $event)
    {
        // Hitung Statistik Peserta
        $stats = [
            'total' => $event->registrations()->count(),
            'approved' => $event->registrations()->where('status', 'approved')->count(),
            'pending' => $event->registrations()->where('status', 'pending')->count(),
            // Nanti bisa tambah 'checked_in' kalau sudah ada absensi
        ];

        return view('admin.events.manage', compact('event', 'stats'));
    }

    // --- UPDATE STATUS (BUKA/TUTUP) ---
    public function updateStatus(Request $request, Event $event)
    {
        // Validasi input hanya boleh: open, closed, atau draft
        $request->validate([
            'status' => 'required|in:open,closed,draft'
        ]);

        $event->update(['status' => $request->status]);

        // Pesan notifikasi sesuai status
        $msg = $request->status == 'open' ? 'Pendaftaran DIBUKA kembali.' : 'Pendaftaran DITUTUP.';

        return back()->with('success', $msg);
    }
    
    // (Opsional) Method edit/update bisa ditambahkan nanti
}