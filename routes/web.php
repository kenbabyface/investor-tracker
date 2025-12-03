<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    // Read-only profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    
    // Edit profile page
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('investors', InvestorController::class);
});


require __DIR__.'/auth.php';