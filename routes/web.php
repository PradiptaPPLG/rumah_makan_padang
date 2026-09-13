<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ReviewController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/orders', [ApiOrderController::class, 'store'])->name('orders.store');

// Halaman form cari pesanan pelanggan
Route::get('/cek-pesanan', [ApiOrderController::class, 'showSearch'])->name('order.search.form');
Route::post('/cek-pesanan', [ApiOrderController::class, 'processSearch'])->name('order.search.submit');

// Halaman status order customer — tampilkan QR Order dan status pesanan (BRD CUS-08)
Route::get('/pesanan/{token}', [ApiOrderController::class, 'orderStatus'])->name('order.status');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes (Guest only)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/login/qr', [AuthController::class, 'qrLogin'])->name('admin.login.qr');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout')->middleware('auth');
});

/*
|--------------------------------------------------------------------------
| Protected Admin Panel Routes (Auth Required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', function () { 
        $user = Auth::user();
        if (empty($user->login_token)) {
            $user->login_token = \Illuminate\Support\Str::random(60);
            $user->save();
        }
        return view('admin.profile.index'); 
    })->name('profile');

    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // POS Cashier Scanner
    Route::get('/pos', [\App\Http\Controllers\Admin\PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/find-order', [\App\Http\Controllers\Admin\PosController::class, 'findOrder'])->name('pos.findOrder');

    // Menu Management
    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
    Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');
    Route::put('/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::post('/menu/{id}/toggle', [MenuController::class, 'toggleActive'])->name('menu.toggleActive');
    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');

    // Branches Management
    Route::get('/branches', [BranchController::class, 'index'])->name('branches.index');
    Route::post('/branches', [BranchController::class, 'store'])->name('branches.store');
    Route::put('/branches/{id}', [BranchController::class, 'update'])->name('branches.update');
    Route::post('/branches/{id}/toggle', [BranchController::class, 'toggleActive'])->name('branches.toggleActive');
    Route::delete('/branches/{id}', [BranchController::class, 'destroy'])->name('branches.destroy');

    // Reviews Moderation
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/toggle-approve', [ReviewController::class, 'toggleApprove'])->name('reviews.toggleApprove');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
