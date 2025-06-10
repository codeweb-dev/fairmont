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
use App\Livewire\Admin\NoonReport as AdminNoonReport;
use App\Livewire\Admin\DepartureReport as AdminDepartureReport;
use App\Livewire\Admin\ArrivalReport as AdminArrivalReport;
use App\Livewire\Admin\BunkeringReport as AdminBunkeringReport;
use App\Livewire\Admin\AllFastReport as AdminAllFastReport;
use App\Livewire\Admin\WeeklyScheduleReport as AdminWeeklyScheduleReport;
use App\Livewire\Admin\CrewMonitoringPlanReport as AdminCrewMonitoringPlanReport;
use App\Livewire\Admin\VoyageReport as AdminVoyageReport;
use App\Livewire\Admin\KpiReport as AdminKpiReport;
use App\Livewire\Admin\PortOfCallReport as AdminPortOfCallReport;
use App\Livewire\Auth\OtpVerify;
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

// Officer
use App\Livewire\Officer\NoonReport as OfficerNoonReport;
use App\Livewire\Officer\DepartureReport as OfficerDepartureReport;
use App\Livewire\Officer\ArrivalReport as OfficerArrivalReport;
use App\Livewire\Officer\BunkeringReport as OfficerBunkeringReport;
use App\Livewire\Officer\AllFastReport as OfficerAllFastReport;
use App\Livewire\Officer\WeeklyScheduleReport as OfficerWeeklyScheduleReport;
use App\Livewire\Officer\CrewMonitoringPlanReport as OfficerCrewMonitoringPlanReport;
use App\Livewire\Officer\VoyageReport as OfficerVoyageReport;
use App\Livewire\Officer\KpiReport as OfficerKpiReport;
use App\Livewire\Officer\PortOfCallReport as OfficerPortOfCallReport;

Route::get('/', Login::class)->name('login');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/otp', OtpVerify::class)
    ->name('otp.verify');

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

        // Reports Admin
        Route::get('/admin-noon-report', AdminNoonReport::class)->name('admin-noon-report');
        Route::get('/admin-departure-report', AdminDepartureReport::class)->name('admin-departure-report');
        Route::get('/admin-arrival-report', AdminArrivalReport::class)->name('admin-arrival-report');
        Route::get('/admin-bunkering-report', AdminBunkeringReport::class)->name('admin-bunkering-report');
        Route::get('/admin-all-fast-report', AdminAllFastReport::class)->name('admin-all-fast-report');
        Route::get('/admin-weekly-schedule-report', AdminWeeklyScheduleReport::class)->name('admin-weekly-schedule-report');
        Route::get('/admin-crew-monitoring-plan-report', AdminCrewMonitoringPlanReport::class)->name('admin-crew-monitoring-plan-report');
        Route::get('/admin-voyage-report', AdminVoyageReport::class)->name('admin-voyage-report');
        Route::get('/admin-kpi-report', AdminKpiReport::class)->name('admin-kpi-report');
        Route::get('/admin-port-of-call-report', AdminPortOfCallReport::class)->name('admin-port-of-call-report');
    });

    Route::group(['middleware' => ['role:unit']], function () {
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
        // Reports Officer
        Route::get('/officer-noon-report', OfficerNoonReport::class)->name('officer-noon-report');
        Route::get('/officer-departure-report', OfficerDepartureReport::class)->name('officer-departure-report');
        Route::get('/officer-arrival-report', OfficerArrivalReport::class)->name('officer-arrival-report');
        Route::get('/officer-bunkering-report', OfficerBunkeringReport::class)->name('officer-bunkering-report');
        Route::get('/officer-all-fast-report', OfficerAllFastReport::class)->name('officer-all-fast-report');
        Route::get('/officer-weekly-schedule-report', OfficerWeeklyScheduleReport::class)->name('officer-weekly-schedule-report');
        Route::get('/officer-crew-monitoring-plan-report', OfficerCrewMonitoringPlanReport::class)->name('officer-crew-monitoring-plan-report');
        Route::get('/officer-voyage-report', OfficerVoyageReport::class)->name('officer-voyage-report');
        Route::get('/officer-kpi-report', OfficerKpiReport::class)->name('officer-kpi-report');
        Route::get('/officer-port-of-call-report', OfficerPortOfCallReport::class)->name('officer-port-of-call-report');
    });
});

require __DIR__ . '/auth.php';
