<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products/{id}/edit', [DashboardController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [DashboardController::class, 'update'])->name('products.update');
});
// Route untuk Simpan Barang Baru
Route::post('/products', [DashboardController::class, 'store'])
    ->middleware(['auth'])
    ->name('products.store');

// Route untuk Hapus Barang
Route::delete('/products/{id}', [DashboardController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('products.destroy');


// Route untuk mengarahkan ke Google/FB
Route::get('/auth/{provider}', [SocialiteController::class, 'redirectToProvider'])
    ->name('auth.socialite');

// Route callback setelah login berhasil
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);

require __DIR__.'/auth.php';
