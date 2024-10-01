<?php

use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StoreOwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserCouponController;
use App\Http\Controllers\UserPointsController;
use App\Models\UserPoint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::resource('owners', StoreOwnerController::class);
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('owner', StoreOwnerController::class);
    Route::resource('store', StoreController::class);
    Route::resource('coupon', CouponController::class);
    // Route::post('/my_coupon/store', [UserCouponController::class, 'store']);
    Route::resource('my_coupon', UserCouponController::class)->only(['index', 'store']);
    Route::get('/my_coupon/scan', [UserCouponController::class, 'scan'])->name('my_coupon.scan');
    Route::get('/my_coupon/stamp/{id}', [UserCouponController::class, 'stamp'])->name('my_coupon.stamp');
    Route::resource('customer', CustomerController::class);
    Route::resource('my_points', UserPointsController::class)->only(['index']);

});

require __DIR__.'/auth.php';
