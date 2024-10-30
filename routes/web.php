<?php

use App\Http\Controllers\CaliberController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GunController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

// Auth
Route::middleware(['auth'])->group(function () {
    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/new', [UserController::class, 'new'])->name('users.new');
        Route::post('/create', [UserController::class, 'create'])->name('users.create');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::get('/delete/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });

    // Customers
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers');
        Route::get('/new', [CustomerController::class, 'new'])->name('customers.new');
        Route::post('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::post('/update/{customer}', [CustomerController::class, 'update'])->name('customers.update');
        Route::get('/delete/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    // Guns
    Route::prefix('guns')->group(function () {
        Route::get('/', [GunController::class, 'index'])->name('guns');
        Route::get('/new', [GunController::class, 'new'])->name('guns.new');
        Route::post('/create', [GunController::class, 'create'])->name('guns.create');
        Route::get('/edit/{gun}', [GunController::class, 'edit'])->name('guns.edit');
        Route::post('/update/{gun}', [GunController::class, 'update'])->name('guns.update');
        Route::get('/delete/{gun}', [GunController::class, 'destroy'])->name('guns.destroy');
    });

    // Calibers
    Route::prefix('calibers')->group(function () {
        Route::get('/', [CaliberController::class, 'index'])->name('calibers');
        Route::get('/new', [CaliberController::class, 'new'])->name('calibers.new');
        Route::post('/create', [CaliberController::class, 'create'])->name('calibers.create');
        Route::get('/edit/{caliber}', [CaliberController::class, 'edit'])->name('calibers.edit');
        Route::post('/update/{caliber}', [CaliberController::class, 'update'])->name('calibers.update');
        Route::get('/delete/{caliber}', [CaliberController::class, 'destroy'])->name('calibers.destroy');
    });

    // Corridors
    Route::prefix('corridors')->group(function () {
        Route::get('/', [GunController::class, 'index'])->name('corridors');
        Route::get('/new', [GunController::class, 'new'])->name('corridors.new');
        Route::post('/create', [GunController::class, 'create'])->name('corridors.create');
        Route::get('/edit/{corridor}', [GunController::class, 'edit'])->name('corridors.edit');
        Route::post('/update/{corridor}', [GunController::class, 'update'])->name('corridors.update');
        Route::get('/delete/{corridor}', [GunController::class, 'destroy'])->name('corridors.destroy');
    });

    // Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions');
        Route::get('/new', [TransactionController::class, 'new'])->name('transactions.new');
        Route::post('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::get('/edit/{transaction}', [TransactionController::class, 'edit'])->name('transactions.edit');
        Route::post('/update/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
        Route::get('/delete/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Profile
    Route::prefix('users')->group(function () {
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Logs
    Route::get('/logs', [App\Http\Controllers\LogController::class, 'index'])->name('logs');

    Route::get('/custom_logout', [App\Http\Controllers\HomeController::class, 'custom_logout'])->name('custom_logout');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});
