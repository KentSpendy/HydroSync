<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Carbon;  

class DashboardController extends Controller
{
    public function index()
    {
        // Get today's date range
        $today = Carbon::today();

        // 1. Total sales for today
        $totalSales = Transaction::whereDate('created_at', $today)->sum('amount');

        // 2. Count of unique customers with transactions today
        $activeCustomers = Transaction::whereDate('created_at', $today)
                                ->distinct('customer_name')
                                ->count('customer_name');

        // 3. Chart Data: Last 7 days
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $chartLabels[] = $day->format('M d');
            $dailyTotal = Transaction::whereDate('created_at', $day)->sum('amount');
            $chartData[] = $dailyTotal;
        }

        return view('dashboard', compact(
            'totalSales',
            'activeCustomers',
            'chartLabels',
            'chartData'
        ));
    }
}
