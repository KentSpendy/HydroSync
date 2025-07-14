<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ExportController;

// Public welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard for authenticated and verified users
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Authenticated users only
Route::middleware(['auth'])->group(function () {

    /**
     * Profile Routes
     */
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * Admin-only Routes
     */
    Route::middleware('role:admin')->group(function () {
        Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
        Route::resource('staff', StaffController::class)->except(['show']);
        Route::get('/sales-history', [SalesHistoryController::class, 'index'])->name('sales.history');

        // Export (Admin only)
        Route::get('/transactions/export/excel', [ExportController::class, 'exportExcel'])->name('transactions.export.excel');
        Route::get('/transactions/export/pdf', [ExportController::class, 'exportPdf'])->name('transactions.export.pdf');
        Route::get('/expenses/export/excel', [ExportController::class, 'exportExpensesExcel'])->name('expenses.export.excel');
        Route::get('/expenses/export/pdf', [ExportController::class, 'exportExpensesPdf'])->name('expenses.export.pdf');
    });

    /**
     * Admin + Employee Shared Routes
     */
    Route::middleware('role:admin,employee')->group(function () {
        Route::resource('transactions', TransactionController::class)->except(['show']);
        Route::patch('/sales-history/{transaction}/mark-paid', [SalesHistoryController::class, 'markAsPaid'])->name('sales.markAsPaid');
    });
});

// Auth scaffolding
require __DIR__.'/auth.php';
