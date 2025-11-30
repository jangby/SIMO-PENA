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
        $query = User::where('role', 'member')->with('profile');

        // LOGIKA PENCARIAN
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Cari berdasarkan Nama atau Email
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  // Atau Cari berdasarkan Asal Sekolah (Relasi Profile)
                  ->orWhereHas('profile', function($qProfile) use ($search) {
                      $qProfile->where('school_origin', 'like', "%{$search}%");
                  });
            });
        }

        $members = $query->latest()->paginate(10);
        
        return view('admin.members.index', compact('members'));
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