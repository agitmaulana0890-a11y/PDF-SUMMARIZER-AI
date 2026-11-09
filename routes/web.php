<?php

use App\Http\Controllers\Frontend\SimulationController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Auth\UserAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Security Awareness Simulation
|--------------------------------------------------------------------------
|
| Frontend: Simulation flow, pretext landing, fake processing, debriefing
| Backend: Admin telemetry dashboard, CSV export, analytics
|
*/

// --- FRONTEND / SIMULATION ROUTES ---
Route::get('/', [SimulationController::class, 'index'])->name('simulation.index');
Route::get('/debriefing', [SimulationController::class, 'debrief'])->name('simulation.debrief');

// Telemetry Endpoints (Supports both /telemetry and /api/telemetry)
Route::prefix('api/telemetry')->group(function () {
    Route::post('/visit', [SimulationController::class, 'recordVisit'])->name('telemetry.visit');
    Route::post('/file-selected', [SimulationController::class, 'recordFileSelected'])->name('telemetry.file');
    Route::post('/cta-clicked', [SimulationController::class, 'recordCtaClicked'])->name('telemetry.cta');
});
Route::prefix('telemetry')->group(function () {
    Route::post('/visit', [SimulationController::class, 'recordVisit']);
    Route::post('/file-selected', [SimulationController::class, 'recordFileSelected']);
    Route::post('/cta-clicked', [SimulationController::class, 'recordCtaClicked']);
});

// --- BACKEND / ADMIN ROUTES ---
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/export-csv', [AdminController::class, 'exportCsv'])->name('admin.export');
    Route::post('/reset', [AdminController::class, 'resetData'])->name('admin.reset');
});

// --- USER AUTHENTICATION ROUTES ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('register.submit');
});

Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');
