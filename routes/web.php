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
use App\Http\Controllers\TransactionsInController;
use App\Http\Controllers\TransactionsOutController;

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

    Route::get('/transactions/payment-in/receipt/{id}', [TransactionsInController::class, 'paymentInReceipt'])->name('transactions-in.receipt');
    Route::get('/get-customer-amounts/{customerId}', [TransactionsInController::class, 'getCustomerAmounts'])->name('getCustomerAmounts');
    Route::get('/transactions-in/export', [TransactionsInController::class, 'dataExport'])->name('transactions-in.export');
    Route::resource('transactions-in', TransactionsInController::class);

    Route::get('/get-vendor-amounts', [TransactionsOutController::class, 'getVendorAmounts'])->name('getVendorAmounts');
    Route::get('/transactions-out/export', [TransactionsOutController::class, 'dataExport'])->name('transactions-out.export');
    Route::resource('transactions-out', TransactionsOutController::class);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


