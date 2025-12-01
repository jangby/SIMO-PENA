<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\MembersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\WahaService;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        // Ambil filter grade dari URL
        $grade = $request->query('grade', 'anggota'); 

        // Query Dasar
        $query = User::where('role', 'member')->with('profile');

        // --- FILTER LOGIC ---
        if ($grade == 'sampah') {
            // Khusus Tab Sampah: Tampilkan yang sudah dihapus (Soft Deleted)
            $query->onlyTrashed();
        } elseif ($grade == 'alumni') {
            // Khusus Alumni
            $query->whereHas('profile', function($q) {
                $q->where('grade', 'alumni');
            });
        } else {
            // Filter Biasa (Calon, Anggota, Kader)
            $query->whereHas('profile', function($q) use ($grade) {
                $q->where('grade', $grade);
            });
        }

        // Logika Pencarian (Tetap Sama)
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

    // --- FUNGSI BARU ---

    // 1. Nonaktifkan (Banned)
    public function deactivate(User $user)
    {
        $user->update(['is_active' => false]);
        return back()->with('success', 'Akun dinonaktifkan. User tidak bisa login.');
    }

    // 2. Luluskan (Jadi Alumni)
    public function graduate(User $user)
    {
        $user->profile()->update(['grade' => 'alumni']);
        return back()->with('success', 'Anggota dinyatakan LULUS dan menjadi Alumni.');
    }

    // 3. Hapus Sementara (Soft Delete -> Masuk Tong Sampah)
    public function destroy(User $user)
    {
        $user->delete(); // Ini tidak menghapus permanen, cuma mengisi deleted_at
        return back()->with('success', 'Data dipindahkan ke Sampah.');
    }

    // 4. Restore (Kembalikan dari Sampah)
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return back()->with('success', 'Data berhasil dipulihkan.');
    }
    
    // 5. Hapus Permanen (Opsional, jika ingin benar-benar menghapus)
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete(); // Hilang selamanya
        return back()->with('success', 'Data dihapus permanen.');
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

    public function activate(User $user, WahaService $waha)
{
    // Aktifkan User
    $user->update(['is_active' => true]);

    // Ubah grade jadi Anggota (jika masih calon)
    // Atau biarkan calon dulu sampai ikut makesta? Terserah kebijakan.
    // Disini kita biarkan grade sesuai data, cuma aktifkan loginnya.

    // Kirim WA Notifikasi
    if ($user->profile && $user->profile->phone) {
        $message = "*AKUN DIAKTIFKAN* ✅\n\n"
                 . "Halo rekan/ita *{$user->name}*,\n"
                 . "Akun Anda di Portal PAC IPNU Limbangan telah diverifikasi dan DIAKTIFKAN oleh Admin.\n\n"
                 . "Sekarang Anda sudah bisa login untuk mendaftar kegiatan atau melengkapi biodata.\n"
                 . "Link Login: " . route('login');

        $waha->sendText($user->profile->phone, $message);
    }

    return back()->with('success', 'Akun berhasil diaktifkan & notifikasi terkirim.');
}
}