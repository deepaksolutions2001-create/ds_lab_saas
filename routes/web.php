<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MedicalReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MedicalTestController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CustomAuthMiddleware;

// Public Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});

// Protected Routes
Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('medical', MedicalReportController::class);
    Route::get('/medical-report/{id}/pdf', [PdfController::class, 'downloadMedicalReport'])->name('medical.pdf');

    // Inventory Routes
    Route::resource('inventory', InventoryController::class)->except(['show', 'edit', 'update', 'destroy']);
    Route::get('inventory/{id}/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
    Route::post('inventory/{id}/adjust', [InventoryController::class, 'updateStock'])->name('inventory.updateStock');

    // Client/Party Routes
    Route::resource('clients', ClientController::class)->middleware('role:super_admin,lab_admin');

    // User Management Routes
    Route::resource('users', UserController::class)->middleware('role:super_admin,lab_admin');

    // Lab Settings / Form Builder Routes
    Route::resource('medical-tests', MedicalTestController::class)->middleware('role:super_admin,lab_admin');

    // Master Data Routes
    Route::resource('occupations', OccupationController::class);
    Route::resource('doctors', DoctorController::class);

    // Reports Routes
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/ledger', [App\Http\Controllers\ReportController::class, 'ledger'])->name('reports.ledger');
    Route::post('/reports/ledger', [App\Http\Controllers\ReportController::class, 'generateLedger'])->name('reports.ledger.generate');
    Route::get('/reports/balances', [App\Http\Controllers\ReportController::class, 'balanceSummary'])->name('reports.balances');
});
