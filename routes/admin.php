<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OfficeController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

// Admin Authentication
Route::get('/dashboard/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/dashboard/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/dashboard/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Panel Routes (protected by admin middleware)
Route::middleware(['web', 'admin'])->prefix('dashboard')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Users
    Route::resource('users', UserController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Articles
    Route::resource('articles', ArticleController::class);

    // Invoices
    Route::resource('invoices', InvoiceController::class);

    // Orders
    Route::resource('orders', OrderController::class);

    // Offices
    Route::resource('offices', OfficeController::class);

    // Visits
    Route::resource('visits', VisitController::class);

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('reports/users', [ReportController::class, 'users'])->name('reports.users');
    Route::get('reports/products', [ReportController::class, 'products'])->name('reports.products');
});