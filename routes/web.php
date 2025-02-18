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
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TransactionsController;


Route::get('/welcome', [DashboardController::class, 'showBlocks']);



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

Route::get('/sales/invoice/{id}', [SalesController::class, 'invoice'])->name('sales.invoice');
Route::resource('sales', SalesController::class);

Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
Route::get('/profile', [SettingController::class, 'profile'])->name('profile');

Route::post('/profile/password/{id}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

Route::get('/transactions/payment-in', [TransactionsController::class, 'paymentIn'])->name('transactions.payment-in.index');
Route::get('/transactions/payment-in/create', [TransactionsController::class, 'paymentInCreate'])->name('transactions.payment-in.create');
Route::post('/transactions/payment-in', [TransactionsController::class, 'paymentInStore'])->name('transactions.payment-in.store');
Route::get('/transactions/payment-in/edit/{id}', [TransactionsController::class, 'paymentInEdit'])->name('transactions.payment-in.edit');
Route::put('/transactions/payment-in/{id}', [TransactionsController::class, 'paymentInUpdate'])->name('transactions.payment-in.update');
Route::delete('/transactions/payment-in/{id}', [TransactionsController::class, 'paymentInDestroy'])->name('transactions.payment-in.destroy');
Route::get('/get-customer-amounts/{customerId}', [TransactionsController::class, 'getCustomerAmounts'])->name('getCustomerAmounts');
Route::get('/transactions/payment-in/receipt/{id}', [TransactionsController::class, 'paymentInReceipt'])->name('transactions.payment-in.receipt');


Route::get('/transactions/payment-out', [TransactionsController::class, 'paymentOut'])->name('transactions.payment-out.index');
Route::get('/transactions/payment-out/create', [TransactionsController::class, 'paymentOutCreate'])->name('transactions.payment-out.create');
Route::get('/get-vendor-amounts', [TransactionsController::class, 'getVendorAmounts'])->name('getVendorAmounts');
Route::post('/transactions/payment-out', [TransactionsController::class, 'paymentOutStore'])->name('transactions.payment-out.store');
Route::get('/transactions/payment-out/edit/{id}', [TransactionsController::class, 'paymentOutEdit'])->name('transactions.payment-out.edit');
Route::put('/transactions/payment-out/{id}', [TransactionsController::class, 'paymentOutUpdate'])->name('transactions.payment-out.update');
Route::delete('/transactions/payment-out/{id}', [TransactionsController::class, 'paymentOutDestroy'])->name('transactions.payment-out.destroy');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});


