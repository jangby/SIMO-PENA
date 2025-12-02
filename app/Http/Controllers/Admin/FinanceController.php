<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Exports\FinanceExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isPac = $user->organization_id == 1;

        $query = Finance::latest('date')->latest('id');

        // --- FILTER ---
        if (!$isPac) {
            $query->where('organization_id', $user->organization_id);
        }

        $finances = $query->paginate(20);
        
        // Hitung Saldo (Juga difilter)
        $saldoQuery = Finance::query();
        if (!$isPac) {
            $saldoQuery->where('organization_id', $user->organization_id);
        }

        // PERBAIKAN: Menggunakan nama variabel 'totalIncome' & 'totalExpense' 
        // agar sesuai dengan View 'admin.finances.index' kamu.
        
        $totalIncome = (clone $saldoQuery)->where('type', 'income')->sum('amount');
        $totalExpense = (clone $saldoQuery)->where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        return view('admin.finances.index', compact('finances', 'totalIncome', 'totalExpense', 'saldo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        Finance::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'date' => $request->date,
            'description' => $request->description,
            'organization_id' => Auth::user()->organization_id, // Simpan ID Organisasi
            // event_id null karena ini transaksi manual
        ]);

        return back()->with('success', 'Transaksi berhasil dicatat.');
    }

    public function export() 
    {
        // Note: Export class perlu disesuaikan juga nanti kalau mau support filter
        return Excel::download(new FinanceExport, 'laporan-keuangan.xlsx');
    }

    public function destroy(Finance $finance)
    {
        $user = Auth::user();
        if ($user->organization_id != 1 && $finance->organization_id != $user->organization_id) {
            abort(403, 'Anda tidak berhak menghapus data keuangan ini.');
        }

        $finance->delete();
        return back()->with('success', 'Transaksi dihapus.');
    }
}