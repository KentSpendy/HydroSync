<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        // Get selected category from query string (e.g., ?category=fuel)
        $category = $request->query('category');

        // Filter expenses if a category is selected
        $expenses = Expense::when($category, function ($query, $category) {
            return $query->where('category', $category);
        })->latest()->paginate(10);

        // Get the total amount of the filtered expenses
        $totalAmount = $expenses->sum('amount');

        // Pass everything to the view
        return view('admin.expenses.index', compact('expenses', 'category', 'totalAmount'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'category' => 'required|in:fuel,maintenance,others',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
        ]);

        Expense::create($request->all());

        return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
    }
}
