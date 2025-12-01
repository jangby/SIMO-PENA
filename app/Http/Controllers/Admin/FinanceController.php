<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Finance;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::latest()->paginate(20);
        
        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $saldo = $totalIncome - $totalExpense;

        return view('admin.finances.index', compact('finances', 'totalIncome', 'totalExpense', 'saldo'));
    }
}