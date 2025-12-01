<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Finance;
use App\Exports\FinanceExport; // Nanti kita buat
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::latest('date')->latest('id')->paginate(20);
        
        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        return view('admin.finances.index', compact('finances', 'totalIncome', 'totalExpense', 'saldo'));
    }

    // --- FUNGSI BARU: SIMPAN TRANSAKSI MANUAL ---
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
            // event_id null karena ini transaksi manual
        ]);

        return back()->with('success', 'Transaksi berhasil dicatat.');
    }

    // --- FUNGSI BARU: EXPORT EXCEL ---
    public function export() 
    {
        return Excel::download(new FinanceExport, 'laporan-keuangan-ipnu.xlsx');
    }

    // --- FUNGSI HAPUS (Jaga-jaga salah input) ---
    public function destroy(Finance $finance)
    {
        $finance->delete();
        return back()->with('success', 'Transaksi dihapus.');
    }
}