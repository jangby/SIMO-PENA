<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $type = $request->query('type', 'incoming');
        
        $query = Letter::where('type', $type)->latest('letter_date');

        // --- FILTER SURAT ---
        if (!$isPac) {
            // Hanya tampilkan surat milik organisasi sendiri
            $query->whereHas('user', function($q) use ($user) {
                $q->where('organization_id', $user->organization_id);
            });
        }

        $letters = $query->paginate(10);

        return view('admin.letters.index', compact('letters', 'type'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $type = $request->query('type', 'incoming');
        
        $nextIndex = 1;
        $romanMonth = $this->getRomawi(date('n'));
        $year = date('Y');

        // Logika Nomor Surat Otomatis (Anti Bentrok)
        if ($type == 'outgoing') {
            $query = Letter::where('type', 'outgoing')
                           ->whereYear('letter_date', date('Y'));
            
            // Jika bukan PAC, hitung nomor urut hanya dari surat organisasi sendiri
            if ($user->organization_id != 1) {
                $query->whereHas('user', function($q) use ($user) {
                    $q->where('organization_id', $user->organization_id);
                });
            }

            $lastLetter = $query->max('index_number');
            $nextIndex = $lastLetter ? $lastLetter + 1 : 1;
        }

        $formattedIndex = sprintf("%03d", $nextIndex);

        return view('admin.letters.create', compact('type', 'formattedIndex', 'romanMonth', 'year', 'nextIndex'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'letter_date' => 'required|date',
            'reference_number' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120',
            'sender' => 'required_if:type,incoming',
            'recipient' => 'required_if:type,outgoing',
        ], [
            'reference_number.required' => 'Nomor Surat wajib diisi.',
            'sender.required_if' => 'Pengirim surat wajib diisi.',
            'recipient.required_if' => 'Tujuan surat wajib diisi.',
        ]);

        $data = [
            'type' => $request->type,
            'letter_date' => $request->letter_date,
            'reference_number' => $request->reference_number,
            'subject' => $request->subject,
            'description' => $request->description,
            'user_id' => Auth::id(), // Menandai pemilik surat
        ];

        if ($request->type == 'incoming') {
            $data['sender'] = $request->sender;
        } else {
            $data['recipient'] = $request->recipient;
            $data['index_number'] = $request->index_number;
            $data['letter_code'] = $request->letter_code;
        }

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('letters', 'public');
        }

        Letter::create($data);

        return redirect()->route('admin.letters.index', ['type' => $request->type])
                         ->with('success', 'Surat berhasil disimpan!');
    }

    public function destroy(Letter $letter)
    {
        // Proteksi Hapus
        $user = Auth::user();
        if ($user->organization_id != 1 && $letter->user->organization_id != $user->organization_id) {
             abort(403, 'AKSES DITOLAK: Anda tidak berhak menghapus surat ini.');
        }

        if ($letter->file_path) Storage::delete('public/' . $letter->file_path);
        $letter->delete();
        return back()->with('success', 'Arsip surat dihapus.');
    }

    private function getRomawi($bulan) {
        $map = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        return $map[$bulan];
    }
}