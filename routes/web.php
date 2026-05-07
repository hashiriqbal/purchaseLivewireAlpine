<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Livewire\PurchaseIndex;
use App\Livewire\PurchaseForm;
use App\Livewire\RoleManager;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {


     Route::get('/purchases', PurchaseIndex::class)
        ->name('purchases.index');
    
    // Route::middleware('role:Admin')->group(function () {

        Route::get('/purchase/create', PurchaseForm::class)
            ->name('purchase.create');

    // });
    Route::get('/roles', RoleManager::class)->name('role');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
