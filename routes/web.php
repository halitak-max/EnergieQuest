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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
    Route::view('/spielregeln', 'spielregeln')->name('spielregeln');
    
    Route::get('/empfehlungen', [ReferralController::class, 'index'])->name('empfehlungen');
    Route::get('/gutscheine', [ReferralController::class, 'vouchers'])->name('gutscheine');
    
    Route::get('/angebot', [UploadController::class, 'index'])->name('uploads.index');
    Route::post('/angebot', [UploadController::class, 'store'])->name('uploads.store');
    Route::delete('/angebot/{upload}', [UploadController::class, 'destroy'])->name('uploads.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/offer/accept', [UploadController::class, 'acceptOffer'])->name('offer.accept');
    Route::get('/offer/status', [UploadController::class, 'getOfferStatus'])->name('offer.status');
    Route::post('/appointment/store', [UploadController::class, 'storeAppointment'])->name('appointment.store');
    Route::get('/appointment/available-slots', [UploadController::class, 'getAvailableSlots'])->name('appointment.available-slots');
    Route::post('/appointment/{appointment}/cancel', [UploadController::class, 'cancelAppointment'])->name('appointment.cancel');
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
        Route::get('accepted-offers', [AdminDashboardController::class, 'acceptedOffers'])->name('accepted-offers');
        Route::get('master-overview', [AdminDashboardController::class, 'masterOverview'])->name('master-overview');
        Route::get('uploads', [AdminDashboardController::class, 'uploads'])->name('uploads');
        Route::get('referrals', [AdminDashboardController::class, 'referrals'])->name('referrals');
        Route::get('appointments', [AdminDashboardController::class, 'appointments'])->name('appointments');
        Route::get('users', [AdminDashboardController::class, 'users'])->name('users');
        Route::patch('referrals/{referral}/status', [AdminDashboardController::class, 'updateReferralStatus'])->name('referrals.updateStatus');
        Route::get('referrals/{referral}/eka', [AdminDashboardController::class, 'getReferralEkaData'])->name('referrals.getEka');
        Route::post('referrals/{referral}/eka', [AdminDashboardController::class, 'saveEkaData'])->name('referrals.saveEka');
        Route::get('users/{user}/eka', [AdminDashboardController::class, 'getUserEkaData'])->name('users.getEka');
        Route::post('users/{user}/eka', [AdminDashboardController::class, 'saveUserEkaData'])->name('users.saveEka');
        Route::patch('users/{user}/profile-lock', [AdminDashboardController::class, 'toggleProfileLock'])->name('users.toggleProfileLock');
        Route::delete('appointments/{appointment}', [AdminDashboardController::class, 'destroyAppointment'])->name('appointments.destroy');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
});

require __DIR__.'/auth.php';
