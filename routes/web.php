<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\UploadController;
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
    return redirect()->route('login');
});

Route::view('/datenschutz', 'datenschutz')->name('datenschutz');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::view('/spielregeln', 'spielregeln')->name('spielregeln');
    
    Route::get('/empfehlungen', [ReferralController::class, 'index'])->name('empfehlungen');
    Route::get('/gutscheine', [ReferralController::class, 'vouchers'])->name('gutscheine');
    
    Route::get('/upload', [UploadController::class, 'index'])->name('uploads.index');
    Route::post('/upload', [UploadController::class, 'store'])->name('uploads.store');
    Route::delete('/upload/{upload}', [UploadController::class, 'destroy'])->name('uploads.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest Admin Routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    // Authenticated Admin Routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::patch('referrals/{referral}/status', [AdminDashboardController::class, 'updateReferralStatus'])->name('referrals.updateStatus');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

require __DIR__.'/auth.php';
