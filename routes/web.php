<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommissionController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\AnalysisController;
use App\Http\Controllers\Admin\ProfileController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Registration Success Route (auth middleware dışına alındı)
Route::get('register/success', [RegisterController::class, 'showRegistrationSuccess'])
     ->name('registration.success');

// Logout Route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes
/*Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::resource('advertisements', AdvertisementController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('users', UserController::class);
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::post('commissions/calculate', [CommissionController::class, 'calculate'])->name('commissions.calculate');
    Route::get('commissions/clear', [CommissionController::class, 'clearAll'])->name('commissions.clear');
    Route::get('commissions/export', [CommissionController::class, 'export'])->name('commissions.export');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
    Route::get('advertisements/{advertisement}/pdf', [AdvertisementController::class, 'generatePDF'])->name('advertisements.pdf');
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');
});*/

// Admin Routes (Admin her şeye erişebilir)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    
    
    Route::resource('users', UserController::class);
    
    Route::get('commissions', [CommissionController::class, 'index'])->name('commissions.index');
    Route::post('commissions/calculate', [CommissionController::class, 'calculate'])->name('commissions.calculate');
    Route::get('commissions/clear', [CommissionController::class, 'clearAll'])->name('commissions.clear');
    Route::get('commissions/export', [CommissionController::class, 'export'])->name('commissions.export');
    Route::get('commissions/{commission}/edit', [CommissionController::class, 'edit'])->name('commissions.edit');
    Route::put('commissions/{commission}', [CommissionController::class, 'update'])->name('commissions.update');
    Route::delete('commissions/{commission}', [CommissionController::class, 'destroy'])->name('commissions.destroy');
    
    Route::get('settings', [SiteSettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // İlan yönetimi routeları sadece admin için
    Route::get('advertisements/create', [AdvertisementController::class, 'create'])->name('advertisements.create');
    Route::post('advertisements', [AdvertisementController::class, 'store'])->name('advertisements.store');
    Route::get('advertisements/{advertisement}/edit', [AdvertisementController::class, 'edit'])->name('advertisements.edit')->middleware('admin.advertisement.access');
    Route::put('advertisements/{advertisement}', [AdvertisementController::class, 'update'])->name('advertisements.update');
    Route::delete('advertisements/{advertisement}', [AdvertisementController::class, 'destroy'])->name('advertisements.destroy');
});

// Sales Consultant Routes (Sadece notlara erişebilir ve dashboard'u görebilir)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,sales_consultant'])->group(function () {
    Route::get('/', [AnalysisController::class, 'index'])->name('dashboard');
    Route::resource('notes', NoteController::class);
});

// Agency Routes (Sadece ilanları görebilir)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,agency,sales_consultant'])->group(function () {
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
    Route::get('advertisements/{advertisement}', [AdvertisementController::class, 'show'])->name('advertisements.show')->middleware('admin.advertisement.access');
    Route::get('advertisements/{advertisement}/pdf', [AdvertisementController::class, 'generatePDF'])->name('advertisements.pdf');
});
