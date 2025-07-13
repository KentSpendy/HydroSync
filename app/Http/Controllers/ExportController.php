<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaction;
use App\Models\Expense;
use App\Exports\ExpensesExport;

class ExportController extends Controller
{
    public function exportExcel()
    {
        return Excel::download(new TransactionsExport, 'transactions.xlsx');
    }

    public function exportPdf()
    {
        $transactions = Transaction::latest()->get();

        $pdf = Pdf::loadView('exports.transactions-pdf', compact('transactions'));
        return $pdf->download('transactions.pdf');
    }

    
    public function exportExpensesExcel()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new ExpensesExport, 'expenses.xlsx');
    }

    public function exportExpensesPdf()
    {
        $expenses = Expense::latest()->get();
        $pdf = Pdf::loadView('exports.expenses-pdf', compact('expenses'));
        return $pdf->download('expenses.pdf');
    }
}


