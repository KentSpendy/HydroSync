<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\CalendarNote;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    // Show the calendar view
    public function index()
    {
        return view('calendar.index');
    }

    // Get all events (transactions + notes) as JSON
    public function events()
    {
        $transactions = Transaction::where('payment_status', '!=', 'paid')
            ->select('customer_name', 'created_at')
            ->get()
            ->map(function ($transaction) {
                return [
                    'title' => $transaction->customer_name,
                    'start' => \Carbon\Carbon::parse($transaction->created_at)->toDateString(),
                    'color' => '#3b82f6',
                ];
            });

        return response()->json($transactions);
    }


    // Store a new calendar note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'note_date' => 'required|date',
        ]);

        CalendarNote::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'note_date' => $request->note_date,
        ]);

        return response()->json(['message' => 'Note added successfully.']);
    }

    public function dayDetails($date)
    {
        $transactions = Transaction::whereDate('created_at', $date)
            ->where('payment_status', '!=', 'paid') // 👈 exclude done
            ->get();

        return response()->json([
            'date' => $date,
            'transactions' => $transactions,
        ]);
    }


    
    public function day($date)
    {
        $transactions = Transaction::whereDate('created_at', $date)->get();

        return response()->json([
            'date' => $date,
            'transactions' => $transactions
        ]);
    }

}

