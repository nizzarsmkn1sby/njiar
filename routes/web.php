<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // POS Routes
    Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory/store', [App\Http\Controllers\InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{product}', [App\Http\Controllers\InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{product}', [App\Http\Controllers\InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/restock', [App\Http\Controllers\InventoryController::class, 'restock'])->name('inventory.restock');
    
    // Category Routes
    Route::post('/categories', [App\Http\Controllers\InventoryController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}', [App\Http\Controllers\InventoryController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/pos', [App\Http\Controllers\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [App\Http\Controllers\PosController::class, 'checkout'])->name('pos.checkout');
    Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}/receipt', [App\Http\Controllers\TransactionController::class, 'receipt'])->name('transactions.receipt');
    Route::get('/transactions/export', [App\Http\Controllers\TransactionController::class, 'export'])->name('transactions.export');
});

require __DIR__.'/auth.php';
