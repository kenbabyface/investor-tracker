<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\PaymentScheduleController;
use App\Http\Middleware\CheckAdminPassword;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


    // Temporary route to fix double cycle dates (REMOVE AFTER RUNNING)
Route::get('/fix-double-cycle-dates-temp-12345', function () {
    $investments = \App\Models\Investment::where('investment_type', 'double_cycle')
        ->where('roi_status', 'pending')
        ->get();

    $updated = 0;
    $results = [];

    foreach ($investments as $investment) {
        $old = $investment->roi_date->format('Y-m-d');
        $investment->roi_date = \Carbon\Carbon::parse($investment->investment_date)->addMonths(12);
        $investment->save();
        
        $results[] = "Updated: {$investment->investor->name} - {$old} → {$investment->roi_date->format('Y-m-d')}";
        $updated++;
    }

    return response()->json([
        'success' => true,
        'updated' => $updated,
        'results' => $results
    ]);
})->middleware('auth');

Route::middleware('auth')->group(function () {
    
    // Read-only profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
    // Edit profile page
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Password Routes
    Route::post('/admin/verify', [AdminPasswordController::class, 'verify'])->name('admin.verify');
    Route::get('/admin/settings', [AdminPasswordController::class, 'showSettings'])->name('admin.settings');
    Route::post('/admin/password/update', [AdminPasswordController::class, 'updatePassword'])->name('admin.password.update');

    //Export 
    Route::get('/investors/export', [InvestorController::class, 'export'])->name('investors.export');
    
    // Protected Routes - Require Admin Password Verification
    Route::middleware(CheckAdminPassword::class)->group(function () {
        // Create Investor (Password Protected)
        Route::get('/investors/create', [InvestorController::class, 'create'])->name('investors.create');
        Route::post('/investors', [InvestorController::class, 'store'])->name('investors.store');
        
        // Create Investment (Password Protected)
        Route::get('/investments/create', [InvestmentController::class, 'create'])->name('investments.create');
        Route::post('/investments', [InvestmentController::class, 'store'])->name('investments.store');
    });
    
    // Investors Resource (READ operations - not protected)
    Route::get('/investors', [InvestorController::class, 'index'])->name('investors.index');
    Route::get('/investors/{investor}', [InvestorController::class, 'show'])->name('investors.show');
    Route::get('/investors/{investor}/edit', [InvestorController::class, 'edit'])->name('investors.edit');
    Route::patch('/investors/{investor}', [InvestorController::class, 'update'])->name('investors.update');
    Route::delete('/investors/{investor}', [InvestorController::class, 'destroy'])->name('investors.destroy');

    // Investments Export 
    Route::get('/investments/export', [InvestmentController::class, 'exportInvestments'])->name('investments.export');
    Route::get('/investments-history/export', [InvestmentController::class, 'exportHistory'])->name('investments.history.export');
    
    // Investment History (BEFORE parameterized routes)
    Route::get('/investments-history', [InvestmentController::class, 'history'])->name('investments.history');
    
    // Investment specific actions 
    Route::get('/investments/{investment}/generate-agreement', [AgreementController::class, 'generate'])->name('investments.generate-agreement');
    Route::post('/investments/{investment}/mark-paid', [InvestmentController::class, 'markAsPaid'])->name('investments.markAsPaid');
    
    // Investment CRUD routes (READ operations)
    Route::get('/investments', [InvestmentController::class, 'index'])->name('investments.index');
    Route::get('/investments/{investment}', [InvestmentController::class, 'show'])->name('investments.show');
    Route::delete('/investments/{investment}', [InvestmentController::class, 'destroy'])->name('investments.destroy');

     // Payment Schedule Route
    Route::get('/payment-schedule', [PaymentScheduleController::class, 'index'])->name('payments.schedule');
});

require __DIR__.'/auth.php';