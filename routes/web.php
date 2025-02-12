<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\DashboardController;


Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_check'])->name('logincheck');

Route::middleware(['auth','prevent-back-history'])->group(function() {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/dashboard/chart', [DashboardController::class, 'getChartData'])->name('admin.dashboard.chart');

Route::resource('users', UserController::class);

Route::get('/customer/search', [CustomerController::class, 'customersearch'])->name('customerSearch');
Route::resource('customers', CustomerController::class);

Route::get('/vendor/search', [VendorController::class, 'vendorsearch'])->name('sales.vendorsearch');
Route::resource('vendors', VendorController::class);


Route::get('/vehicle/search', [VehicleController::class, 'vehicleSearch'])->name('sales.vehicleSearch');
Route::resource('vehicles', VehicleController::class);


Route::resource('taxes', TaxController::class);

Route::resource('products', ProductController::class);


Route::resource('sales', SalesController::class);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


