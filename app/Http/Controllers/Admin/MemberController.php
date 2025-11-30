<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        // Ambil semua user yang role-nya 'member', urutkan terbaru, 10 per halaman
        $members = User::where('role', 'member')->latest()->paginate(10);
        
        return view('admin.members.index', compact('members'));
    }

    // Menampilkan detail user tertentu
    public function show(User $user)
    {
        // Kita tidak perlu query manual, Laravel otomatis mencarikan User berdasarkan ID
        return view('admin.members.show', compact('user'));
    }
}