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
use App\Livewire\Admin\Trash;
use App\Livewire\Admin\Vessel;
use App\Livewire\Admin\Report;

// Unit
use App\Livewire\Unit\AllFast;
use App\Livewire\Unit\ArrivalReport;
use App\Livewire\Unit\Bunkering;
use App\Livewire\Unit\CrewMonitoringPlan;
use App\Livewire\Unit\DepartureReport;
use App\Livewire\Unit\Kpi;
use App\Livewire\Unit\NoonReport;
use App\Livewire\Unit\PortOfCall;
use App\Livewire\Unit\VoyageReport;
use App\Livewire\Unit\WeeklySchedule;

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
        Route::get('/users', Users::class)->name('users');
        Route::get('/roles', Roles::class)->name('roles');
        Route::get('/audit', Audit::class)->name('audit');
        Route::get('/trash', Trash::class)->name('trash');
        Route::get('/vessel', Vessel::class)->name('vessel');
        Route::get('/reports', Report::class)->name('reports');
    });

    Route::group(['middleware' => ['role:unit']], function () {
        // Unit User Dashboard
        // Report Export
        // Search Function
        // CRUD Function for report
        // Session Timeout
        // Draft Function
        Route::get('/noon-report', NoonReport::class)->name('noon-report');
        Route::get('/departure-report', DepartureReport::class)->name('departure-report');
        Route::get('/arrival-report', ArrivalReport::class)->name('arrival-report');
        Route::get('/bunkering', Bunkering::class)->name('bunkering');
        Route::get('/all-fast', AllFast::class)->name('all-fast');
        Route::get('/weekly-schedule', WeeklySchedule::class)->name('weekly-schedule');
        Route::get('/crew-monitoring-plan', CrewMonitoringPlan::class)->name('crew-monitoring-plan');
        Route::get('/voyage-report', VoyageReport::class)->name('voyage-report');
        Route::get('/kpi', Kpi::class)->name('kpi');
        Route::get('/port-of-call', PortOfCall::class)->name('port-of-call');
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
