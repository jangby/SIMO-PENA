<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Registration; // <--- TAMBAHAN PENTING
use Illuminate\Http\Request;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\WahaService;
use Illuminate\Support\Facades\DB; // <--- TAMBAHAN UNTUK TRANSACTION

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $grade = $request->query('grade', 'anggota'); 

        // Query Dasar
        $query = User::where('role', 'member')->with('profile');

        // Filter Grade
        if ($grade == 'sampah') {
            $query->onlyTrashed();
        } elseif ($grade == 'alumni') {
            $query->whereHas('profile', function($q) {
                $q->where('grade', 'alumni');
            });
        } else {
            $query->whereHas('profile', function($q) use ($grade) {
                $q->where('grade', $grade);
            });
        }

        // Filter Gender
        if ($request->has('gender') && $request->gender != '') {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('gender', $request->gender);
            });
        }

        // Pencarian
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($p) use ($search) {
                      $p->where('school_origin', 'like', "%{$search}%");
                  });
            });
        }

        $members = $query->latest()->paginate(10);
        
        return view('admin.members.index', compact('members', 'grade'));
    }

    public function edit(User $user)
    {
        return view('admin.members.edit', compact('user'));
    }

    // --- PERBAIKAN UTAMA DI SINI ---
    public function update(Request $request, User $user)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|numeric',
            'grade' => 'required|string',
            'school_origin' => 'required|string',
            'gender' => 'required|in:L,P',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'nia_ipnu' => 'nullable|string',
        ]);

        // Gunakan Transaction agar aman
        DB::transaction(function () use ($request, $user) {
            
            // A. Update Data User (Akun Login)
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // B. Update Data Profile (Biodata)
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'phone' => $request->phone,
                    'grade' => $request->grade,
                    'school_origin' => $request->school_origin,
                    'gender' => $request->gender,
                    'birth_place' => $request->birth_place,
                    'birth_date' => $request->birth_date,
                    'nia_ipnu' => $request->nia_ipnu,
                ]
            );

            // C. UPDATE DATA DI TABEL REGISTRATIONS (Sinkronisasi)
            // Ini akan mengupdate semua data event yang pernah diikuti user ini
            // agar namanya, sekolahnya, dan gendernya sesuai dengan data terbaru.
            Registration::where('user_id', $user->id)->update([
                'name'          => $request->name,
                'phone'         => $request->phone,
                'school_origin' => $request->school_origin,
                'gender'        => $request->gender,       // Penting untuk filter IPNU/IPPNU
                'birth_place'   => $request->birth_place,
                'birth_date'    => $request->birth_date,
            ]);

        });

        return redirect()->route('admin.members.index')->with('success', 'Data anggota (dan riwayat pendaftarannya) berhasil diperbarui.');
    }

    // --- FUNGSI LAINNYA TETAP SAMA ---

    public function deactivate(User $user)
    {
        $user->update(['is_active' => false]);
        return back()->with('success', 'Akun dinonaktifkan. User tidak bisa login.');
    }

    public function graduate(User $user)
    {
        $user->profile()->update(['grade' => 'alumni']);
        return back()->with('success', 'Anggota dinyatakan LULUS dan menjadi Alumni.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Data dipindahkan ke Sampah.');
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return back()->with('success', 'Data berhasil dipulihkan.');
    }
    
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return back()->with('success', 'Data dihapus permanen.');
    }

    public function show(User $user)
    {
        return view('admin.members.show', compact('user'));
    }

    public function export() 
    {
        return Excel::download(new MembersExport, 'data-anggota-ipnu.xlsx');
    }

    public function activate(User $user, WahaService $waha)
    {
        $user->update(['is_active' => true]);

        if ($user->profile && $user->profile->phone) {
            $message = "*AKUN DIAKTIFKAN* ✅\n\n"
                     . "Halo rekan/ita *{$user->name}*,\n"
                     . "Akun Anda di Portal PAC IPNU Limbangan telah diverifikasi dan DIAKTIFKAN oleh Admin.\n\n"
                     . "Sekarang Anda sudah bisa login.\n"
                     . "Link: " . route('login');

            $waha->sendText($user->profile->phone, $message);
        }

        return back()->with('success', 'Akun berhasil diaktifkan.');
    }
}