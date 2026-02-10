<?php

use Illuminate\Support\Facades\Route;

Route::view('/admin/create', 'admin.create')->name('admin.create');
Route::view('/admin/login', 'admin.login')->name('admin.login');
Route::view('/admin/verify-email', 'admin.verify-email')->name('admin.verify-email');
Route::get('/admin/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/admin/sidebar', fn () => view('admin.sidebar'))->name('admin.sidebar');
Route::get('/admin/products', fn () => view('admin.products'))->name('admin.products');
Route::get('/admin/stockout', fn () => view('admin.stockout'))->name('admin.stockout');
Route::get('/admin/stockin', fn () => view('admin.stockin'))->name('admin.stockin');
Route::get('/admin/reports', fn () => view('admin.reports'))->name('admin.reports');