<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\GoogleAuthController;
use App\Http\Controllers\Admin\DemoSaleController;
Route::prefix('admin')->name('admin.')->group(function () {

  // Landing
     Route::view('/landing', 'admin.landing.landing')->name('landing');
    Route::get('/set-language/{lang}', function ($lang) {

        $allowed = [
            'en','es','fr','de','zh','ja','ko','ar','hi','ru','pt','it',
            'tl','ceb','ilo','hil','bik','war','pang','kap','mrn','tau'
        ];

        if(in_array($lang, $allowed)){
            session(['locale' => $lang]);
            app()->setLocale($lang);
        }

        return redirect()->route('admin.landing');

    })->name('set-language');

    Route::get('/intro', [DemoSaleController::class, 'intro'])->name('intro');
    Route::get('/productsSale', [DemoSaleController::class, 'products'])->name('products');
    Route::get('/review', [DemoSaleController::class, 'review'])->name('review');
    Route::get('/payment', [DemoSaleController::class, 'payment'])->name('payment');
    Route::get('/receipt', [DemoSaleController::class, 'receipt'])->name('receipt');
    // Login
    Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])
        ->name('google.redirect');

    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])
        ->name('google.callback');

    Route::get('/login', [AuthController::class, 'showSignIn'])->name('login.signIn');
    Route::post('/login', [AuthController::class, 'signIn'])->name('signIn.store');
    Route::view('/login/eemail', 'admin.login.eemail')->name('login.eemail');
    Route::get('/login/otp-sent', function () {
        if (!session('admin_forgot_data')) {
            return redirect()->route('admin.login.eemail');
        }
        return view('admin.login.otp-sent');
    })->name('login.otp-sent');
    Route::post('/login/send-otp', [AuthController::class, 'sendForgotOtp'])->name('login.send-otp');

    Route::post('/login/verify-otp', [AuthController::class, 'verifyForgotOtp'])->name('login.verify-otp');
    Route::get('/login/resend-otp', [AuthController::class, 'resendForgotOtp'])->name('login.resend-otp');
    // admin.php
    Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('login.reset-password');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('login.update-password');

    // Create admin account (controller)
    Route::get('/create-account', [AuthController::class, 'showCreate'])->name('create.signUp');
    Route::post('/create-account', [AuthController::class, 'storeCreate'])->name('create.store');
    Route::get('/verify-email', [AuthController::class, 'showVerify'])->name('create.verify-email');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify-email.check');
    Route::get('/resend-code', [AuthController::class, 'resendCode'])->name('resend-code');

    // Admin pages
    Route::view('/dashboard', 'admin.dashboard')->middleware('auth:admin')->name('dashboard');
    Route::view('/sidebar', 'admin.sidebar')->name('sidebar');
    Route::resource('/products', ProductController::class);
    Route::post('/receipts/store', [ReceiptController::class, 'store'])->name('receipts.store');
    Route::post('/products/archive', [ProductController::class, 'archive'])
        ->name('products.archive');
    Route::view('/stockout', 'admin.stockout')->name('stockout');
    Route::view('/stockin', 'admin.stockin')->name('stockin');
    Route::view('/reports', 'admin.reports')->name('reports');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});
