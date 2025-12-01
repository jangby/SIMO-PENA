<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter grade dari URL (default tampilkan 'anggota')
        // Opsi: 'anggota' atau 'kader'
        $grade = $request->query('grade', 'anggota'); 

        $query = User::where('role', 'member')
                     ->whereHas('profile', function($q) use ($grade) {
                         $q->where('grade', $grade);
                     })
                     ->with('profile');

        // Logika Pencarian (Search)
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($p) use ($search) {
                      $p->where('school_origin', 'like', "%{$search}%");
                  });
            });
        }

        $members = $query->latest()->paginate(10);
        
        // Kita kirim variabel $grade ke view untuk penanda tab aktif
        return view('admin.members.index', compact('members', 'grade'));
    }

    public function show(User $user)
    {
        return view('admin.members.show', compact('user'));
    }

    // FITUR EXPORT EXCEL
    public function export() 
    {
        return Excel::download(new MembersExport, 'data-anggota-ipnu.xlsx');
    }
}