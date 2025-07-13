<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SalesHistoryController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve filter inputs
        $status = $request->query('status');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Start the base query
        $query = Transaction::query();

        // Apply status filter if present
        if (!empty($status)) {
            $query->where('payment_status', $status);
        }

        // Apply date range filters
        if ($startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($startDate)->startOfDay());
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Calculate total sales before pagination
        $totalSales = $query->sum('amount');

        // Paginate results and retain query parameters
        $transactions = $query->latest()->paginate(10)->appends($request->all());

        // Return view with data
        return view('admin.sales.index', compact(
            'transactions',
            'status',
            'startDate',
            'endDate',
            'totalSales'
        ));
    }

    public function markAsPaid(Transaction $transaction)
    {
        if ($transaction->payment_status === 'debt') {
            $transaction->update(['payment_status' => 'paid']);
            return redirect()->route('sales.history')->with('success', 'Transaction marked as paid.');
        }

        return redirect()->route('sales.history')->with('info', 'Transaction is already paid.');
    }
}
