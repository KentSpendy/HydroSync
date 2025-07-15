<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    // Show all transactions
    public function index()
    {
        $transactions = Transaction::where('payment_status', '!=', 'paid')
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }


    // Show create form
    public function create()
    {
        return view('transactions.create');
    }

    // Store new transaction
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,debt',
            'order_details' => 'nullable|string',
            'delivery_group' => 'nullable|string',
        ]);

        Transaction::create($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction recorded successfully.');
    }
    

    
    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', compact('transaction'));
    }



    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,debt',
            'order_details' => 'nullable|string',
            'delivery_group' => 'nullable|string',
        ]);

        $transaction->update($request->all());

        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
    }



    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    

    public function markAsDone(Transaction $transaction)
    {
        $transaction->update([
            'payment_status' => 'paid',
        ]);

        return redirect()->route('transactions.index')->with('success', 'Transaction marked as done and moved to Sales History.');
    }

}
