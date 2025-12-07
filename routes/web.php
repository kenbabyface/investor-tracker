<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index']) ->middleware(['auth', 'verified']) ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Read-only profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
    // Edit profile page
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // IMPORTANT: Export 
    Route::get('/investors/export', [InvestorController::class, 'export'])->name('investors.export');
    
    // Investors Resource
    Route::resource('investors', InvestorController::class);

    // Investments Export
    Route::get('/investments/export', [InvestmentController::class, 'exportInvestments'])->name('investments.export');
    Route::get('/investments-history/export', [InvestmentController::class, 'exportHistory'])->name('investments.history.export');
    
    // Investments
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
    Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
    Route::post('/investments/{investment}/mark-paid', [InvestmentController::class, 'markAsPaid'])->name('investments.markAsPaid');
    Route::delete('/investments/{investment}', [InvestmentController::class, 'destroy'])->name('investments.destroy');
    
    // Investment History
    Route::get('/investments-history', [InvestmentController::class, 'history'])->name('investments.history');
});


require __DIR__.'/auth.php';