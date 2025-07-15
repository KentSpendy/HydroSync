<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SalesHistoryController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\OtpController;

/**
 * 🌐 Public Welcome Page
 */
Route::get('/', fn () => view('welcome'));

/**
 * 🔐 OTP Verification Routes
 */
Route::get('/verify-otp', [OtpController::class, 'showVerifyPage'])->name('otp.verify.page');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');

/**
 * 🧑‍💼 Dashboard (Must be logged in, verified email, and OTP verified)
 */
Route::middleware(['auth', 'verified'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

/**
 * ✅ Routes for Users Who Are Authenticated + OTP Verified
 */
Route::middleware(['auth', 'otp.verified'])->group(function () {

    /**
     * 👤 Profile Management
     */
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * 📅 Calendar Module
     */
    Route::prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', [CalendarController::class, 'index'])->name('index');
        Route::get('/events', [CalendarController::class, 'events'])->name('events');
        Route::get('/day/{date}', [CalendarController::class, 'dayDetails'])->name('day.details');
        Route::post('/notes', [CalendarController::class, 'storeNote'])->name('notes.store');
        Route::delete('/notes/{id}', [CalendarController::class, 'deleteNote'])->name('notes.delete');
    });

    /**
     * 🛡️ Admin-Only Routes
     */
    Route::middleware('role:admin')->group(function () {
        Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
        Route::resource('staff', StaffController::class)->except(['show']);
        Route::get('/sales-history', [SalesHistoryController::class, 'index'])->name('sales.history');

        // Export
        Route::get('/transactions/export/excel', [ExportController::class, 'exportExcel'])->name('transactions.export.excel');
        Route::get('/transactions/export/pdf', [ExportController::class, 'exportPdf'])->name('transactions.export.pdf');
        Route::get('/expenses/export/excel', [ExportController::class, 'exportExpensesExcel'])->name('expenses.export.excel');
        Route::get('/expenses/export/pdf', [ExportController::class, 'exportExpensesPdf'])->name('expenses.export.pdf');
    });

    /**
     * 👷 Admin + Employee Shared Routes
     */
    Route::middleware('role:admin,employee')->group(function () {
        Route::resource('transactions', TransactionController::class)->except(['show']);
        Route::patch('/sales-history/{transaction}/mark-paid', [SalesHistoryController::class, 'markAsPaid'])->name('sales.markAsPaid');
        Route::patch('/transactions/{transaction}/done', [TransactionController::class, 'markAsDone'])->name('transactions.done');
    });
});

/**
 * 🔐 Laravel Breeze/Fortify Auth Routes (login, register, etc.)
 */
require __DIR__ . '/auth.php';
