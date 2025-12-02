<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\WahaService;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    /**
     * Helper: Cek apakah Admin berhak mengakses User target
     */
    private function checkAccess(User $targetUser)
    {
        $currentUser = Auth::user();
        // Jika bukan PAC (Super Admin) DAN organisasi target berbeda dengan organisasi admin
        if ($currentUser->organization_id != 1 && $currentUser->organization_id != $targetUser->organization_id) {
            abort(403, 'AKSES DITOLAK: Anda tidak memiliki izin mengelola anggota dari organisasi lain.');
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $grade = $request->query('grade', 'anggota'); 

        // Query Dasar
        $query = User::where('role', 'member')->with('profile');

        // --- FILTER ORGANISASI ---
        if (!$isPac) {
            $query->where('organization_id', $user->organization_id);
        }

        // --- FILTER GRADE ---
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

        // --- PENCARIAN ---
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

    public function show(User $user)
    {
        $this->checkAccess($user);
        return view('admin.members.show', compact('user'));
    }

    // 1. Nonaktifkan (Banned)
    public function deactivate(User $user)
    {
        $this->checkAccess($user);
        $user->update(['is_active' => false]);
        return back()->with('success', 'Akun dinonaktifkan. User tidak bisa login.');
    }

    // 2. Luluskan (Jadi Alumni)
    public function graduate(User $user)
    {
        $this->checkAccess($user);
        $user->profile()->update(['grade' => 'alumni']);
        return back()->with('success', 'Anggota dinyatakan LULUS dan menjadi Alumni.');
    }

    // 3. Hapus Sementara (Soft Delete)
    public function destroy(User $user)
    {
        $this->checkAccess($user);
        $user->delete();
        return back()->with('success', 'Data dipindahkan ke Sampah.');
    }

    // 4. Restore (Kembalikan dari Sampah)
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->checkAccess($user); // Cek akses dulu
        $user->restore();
        return back()->with('success', 'Data berhasil dipulihkan.');
    }
    
    // 5. Hapus Permanen
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->checkAccess($user);
        $user->forceDelete();
        return back()->with('success', 'Data dihapus permanen.');
    }

    // 6. Aktifkan Akun
    public function activate(User $user, WahaService $waha)
    {
        $this->checkAccess($user);

        $user->update(['is_active' => true]);

        // Kirim WA Notifikasi
        if ($user->profile && $user->profile->phone) {
            $message = "*AKUN DIAKTIFKAN* ✅\n\n"
                     . "Halo rekan/ita *{$user->name}*,\n"
                     . "Akun Anda di Portal PAC IPNU Limbangan telah diverifikasi dan DIAKTIFKAN oleh Admin.\n\n"
                     . "Sekarang Anda sudah bisa login.\n"
                     . "Link Login: " . route('login');

            $waha->sendText($user->profile->phone, $message);
        }

        return back()->with('success', 'Akun berhasil diaktifkan & notifikasi terkirim.');
    }

    public function export() 
    {
        // Catatan: Jika ingin export terfilter juga, class MembersExport perlu dimodifikasi
        return Excel::download(new MembersExport, 'data-anggota-ipnu.xlsx');
    }
}