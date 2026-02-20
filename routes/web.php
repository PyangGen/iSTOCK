<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

Route::prefix('admin')->name('admin.')->group(function () {

 
   // Login
  Route::get('/login', [AdminAuthController::class, 'showSignIn'])->name('login.signIn');
  Route::post('/login', [AdminAuthController::class, 'signIn'])->name('signIn.store');
 Route::view('/login/eemail', 'admin.login.eemail')->name('login.eemail');
Route::get('/login/otp-sent', function () {
    if (!session('admin_forgot_data')) {
        return redirect()->route('admin.login.eemail');
    }
    return view('admin.login.otp-sent');})->name('login.otp-sent');
Route::post('/login/send-otp', [AdminAuthController::class, 'sendForgotOtp'])
    ->name('login.send-otp');

Route::post('/login/verify-otp', [AdminAuthController::class, 'verifyForgotOtp'])->name('login.verify-otp');
Route::get('/login/resend-otp', [AdminAuthController::class, 'resendForgotOtp'])->name('login.resend-otp');
// admin.php
Route::get('/reset-password', [AdminAuthController::class, 'showResetPassword'])->name('login.reset-password');
Route::post('/reset-password', [AdminAuthController::class, 'updatePassword'])->name('login.update-password');

  // Create admin account (controller)
  Route::get('/create-account', [AdminAuthController::class, 'showCreate'])->name('create.signUp');
  Route::post('/create-account', [AdminAuthController::class, 'storeCreate'])->name('create.store');
  Route::get('/verify-email', [AdminAuthController::class, 'showVerify'])->name('create.verify-email');
  Route::post('/verify-email', [AdminAuthController::class, 'verifyEmail'])->name('verify-email.check');
  Route::get('/resend-code', [AdminAuthController::class, 'resendCode']) ->name('resend-code');

  // Admin pages
  Route::view('/dashboard', 'admin.dashboard')->middleware('auth:admin')->name('dashboard');
  Route::view('/sidebar', 'admin.sidebar')->name('sidebar');
  Route::view('/products', 'admin.products')->name('products');
  Route::view('/stockout', 'admin.stockout')->name('stockout');
  Route::view('/stockin', 'admin.stockin')->name('stockin');
  Route::view('/reports', 'admin.reports')->name('reports');
     Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

});
