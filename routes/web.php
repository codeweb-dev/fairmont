<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;

// Admin
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Audit;

Route::get('/', Login::class)->name('login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::group(['middleware' => ['role:admin']], function () {
        // User Management
        // Role Management
        // Vessel Management
        // Report Management
        // Audit Logs
        // Trash/Deleted Reports Recovery
        Route::get('/users', Users::class)->middleware(['auth', 'verified'])->name('users');
        Route::get('/roles', Roles::class)->middleware(['auth', 'verified'])->name('roles');
        Route::get('/audits', Audit::class)->middleware(['auth', 'verified'])->name('audits');
    });

    Route::group(['middleware' => ['role:unit']], function () {
        // Unit User Dashboard
        // Report Export
        // Search Function
        // CRUD Function for report
        // Session Timeout
        // Draft Function
    });

    Route::group(['middleware' => ['role:officer']], function () {
        // Office User Dashboard
        // Access to all reports of its assigned access role
        // Report Export
        // Search Function
        // Session Timeout
        // Draft Function
        // View and Manage Report (Can't create reports)
    });
});

require __DIR__ . '/auth.php';
