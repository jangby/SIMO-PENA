<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    // 1. Tampilkan Daftar (Tab View)
    public function index(Request $request)
    {
        // Default tampilkan surat masuk
        $type = $request->query('type', 'incoming');
        
        $letters = Letter::where('type', $type)
                    ->latest('letter_date')
                    ->paginate(10);

        return view('admin.letters.index', compact('letters', 'type'));
    }

    // 2. Form Tambah
    public function create(Request $request)
    {
        $type = $request->query('type', 'incoming');
        
        $nextIndex = 1;
        $romanMonth = $this->getRomawi(date('n'));
        $year = date('Y');

        // Jika Surat Keluar, cari nomor urut terakhir
        if ($type == 'outgoing') {
            $lastLetter = Letter::where('type', 'outgoing')
                            ->whereYear('letter_date', date('Y'))
                            ->max('index_number');
            
            $nextIndex = $lastLetter ? $lastLetter + 1 : 1;
        }

        // Format angka jadi 3 digit (001, 002, dst)
        $formattedIndex = sprintf("%03d", $nextIndex);

        return view('admin.letters.create', compact('type', 'formattedIndex', 'romanMonth', 'year', 'nextIndex'));
    }

    // 3. Simpan Surat
    public function store(Request $request)
    {
        // 1. Validasi Diperketat
        $request->validate([
            'type' => 'required|in:incoming,outgoing',
            'letter_date' => 'required|date',
            'reference_number' => 'required|string|max:255', // Wajib ada
            'subject' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            // Validasi kondisional
            'sender' => 'required_if:type,incoming',   // Wajib jika surat masuk
            'recipient' => 'required_if:type,outgoing', // Wajib jika surat keluar
        ], [
            // Custom pesan error biar jelas
            'reference_number.required' => 'Nomor Surat wajib diisi.',
            'sender.required_if' => 'Pengirim surat wajib diisi.',
            'recipient.required_if' => 'Tujuan surat wajib diisi.',
        ]);

        // 2. Siapkan Data
        $data = [
            'type' => $request->type,
            'letter_date' => $request->letter_date,
            'reference_number' => $request->reference_number,
            'subject' => $request->subject,
            'description' => $request->description, // Jika ada
            'user_id' => Auth::id(),
        ];

        // Data spesifik tipe
        if ($request->type == 'incoming') {
            $data['sender'] = $request->sender;
        } else {
            $data['recipient'] = $request->recipient;
            $data['index_number'] = $request->index_number;
            $data['letter_code'] = $request->letter_code; // Simpan kode surat (A, B, dll)
        }

        // 3. Upload File
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('letters', 'public');
        }

        // 4. Simpan ke Database
        Letter::create($data);

        return redirect()->route('admin.letters.index', ['type' => $request->type])
                         ->with('success', 'Surat berhasil disimpan!');
    }

    // 4. Hapus
    public function destroy(Letter $letter)
    {
        if ($letter->file_path) Storage::delete('public/' . $letter->file_path);
        $letter->delete();
        return back()->with('success', 'Arsip surat dihapus.');
    }

    // HELPER: Ubah Angka Bulan ke Romawi
    private function getRomawi($bulan) {
        $map = [1=>'I', 2=>'II', 3=>'III', 4=>'IV', 5=>'V', 6=>'VI', 7=>'VII', 8=>'VIII', 9=>'IX', 10=>'X', 11=>'XI', 12=>'XII'];
        return $map[$bulan];
    }
}