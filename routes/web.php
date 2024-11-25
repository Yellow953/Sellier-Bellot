<?php

use App\Http\Controllers\BackupController;
use App\Http\Controllers\CaliberController;
use App\Http\Controllers\LaneController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PistolController;
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
        Route::get('/download/{customer}', [CustomerController::class, 'download'])->name('customers.download');
        Route::get('/new_transaction/{customer}', [CustomerController::class, 'new_transaction'])->name('customers.new_transaction');
    });

    // Pistols
    Route::prefix('pistols')->group(function () {
        Route::get('/', [PistolController::class, 'index'])->name('pistols');
        Route::get('/new', [PistolController::class, 'new'])->name('pistols.new');
        Route::post('/create', [PistolController::class, 'create'])->name('pistols.create');
        Route::get('/edit/{pistol}', [PistolController::class, 'edit'])->name('pistols.edit');
        Route::post('/update/{pistol}', [PistolController::class, 'update'])->name('pistols.update');
        Route::get('/delete/{pistol}', [PistolController::class, 'destroy'])->name('pistols.destroy');
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

    // Lanes
    Route::prefix('lanes')->group(function () {
        Route::get('/', [LaneController::class, 'index'])->name('lanes');
        Route::get('/new', [LaneController::class, 'new'])->name('lanes.new');
        Route::post('/create', [LaneController::class, 'create'])->name('lanes.create');
        Route::get('/edit/{lane}', [LaneController::class, 'edit'])->name('lanes.edit');
        Route::post('/update/{lane}', [LaneController::class, 'update'])->name('lanes.update');
        Route::get('/delete/{lane}', [LaneController::class, 'destroy'])->name('lanes.destroy');
    });

    // Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('transactions');
        Route::post('/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::get('/show/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
        Route::get('/delete/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    });

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/save_password', [ProfileController::class, 'save_password'])->name('profile.save_password');
    });

    // Backup
    Route::prefix('backup')->group(function () {
        Route::get('/export', [BackupController::class, 'export'])->name('backup.export');
        Route::post('/import', [BackupController::class, 'import'])->name('backup.import');
        Route::get('/', [BackupController::class, 'index'])->name('backup');
    });

    // Logs
    Route::get('/logs', [App\Http\Controllers\LogController::class, 'index'])->name('logs');

    Route::get('/custom_logout', [App\Http\Controllers\HomeController::class, 'custom_logout'])->name('custom_logout');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Route::get('/customers/fetch', [CustomerController::class, 'fetch'])->name('customers.fetch');
Route::get('/transactions/fetch_options', [TransactionController::class, 'fetch_options'])->name('transactions.fetch_options');
Route::get('/transactions/today', [TransactionController::class, 'fetchTodayTransactions'])->name('transactions.today');
