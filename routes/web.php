<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\OtpVerify;
use App\Livewire\Auth\Login;
use App\Livewire\Unassigned;

// Admin
use App\Livewire\Admin\Users;
use App\Livewire\Admin\Roles;
use App\Livewire\Admin\Audit;
use App\Livewire\Admin\Trash;
use App\Livewire\Admin\Vessel;
use App\Livewire\Admin\TotalReport as AdminTotalReport;
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

// Unit
use App\Livewire\Unit\TotalReport;
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

// Table Reports Unit
use App\Livewire\Unit\TableNoonReport;
use App\Livewire\Unit\TableDepartureReport;
use App\Livewire\Unit\TableArrivalReport;
use App\Livewire\Unit\TableBunkeringReport;
use App\Livewire\Unit\TableAllFastReport;
use App\Livewire\Unit\TableWeeklyScheduleReport;
use App\Livewire\Unit\TableVoyageReport;
use App\Livewire\Unit\TableKpiReport;
use App\Livewire\Unit\TablePortOfCallReport;
use App\Livewire\Unit\TableCrewChange;
use App\Livewire\Unit\TableOnBoardCrew;

// Edit Unit
use App\Livewire\Unit\EditAllFastReport;
use App\Livewire\Unit\EditVoyageReport;

// Officer
use App\Livewire\Officer\TotalReport as OfficerTotalReport;
use App\Livewire\Officer\NoonReport as OfficerNoonReport;
use App\Livewire\Officer\DepartureReport as OfficerDepartureReport;
use App\Livewire\Officer\ArrivalReport as OfficerArrivalReport;
use App\Livewire\Officer\BunkeringReport as OfficerBunkeringReport;
use App\Livewire\Officer\AllFastReport as OfficerAllFastReport;
use App\Livewire\Officer\WeeklyScheduleReport as OfficerWeeklyScheduleReport;
use App\Livewire\Officer\VoyageReport as OfficerVoyageReport;
use App\Livewire\Officer\KpiReport as OfficerKpiReport;
use App\Livewire\Officer\PortOfCallReport as OfficerPortOfCallReport;
use App\Livewire\Officer\OnBoardCrew as OfficerOnBoardCrew;
use App\Livewire\Officer\CrewChange as OfficerCrewChange;

Route::middleware('guest')->group(function () {
    Route::get('/', Login::class)->name('login');
});

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

    Route::get('/unassigned', Unassigned::class)->name('unassigned');

    Route::group(['middleware' => ['role:admin']], function () {
        Route::get('/users', Users::class)->name('users');
        Route::get('/roles', Roles::class)->name('roles');
        Route::get('/audit', Audit::class)->name('audit');
        Route::get('/trash', Trash::class)->name('trash');
        Route::get('/vessel', Vessel::class)->name('vessel');

        // Reports Admin
        Route::get('/admin-total-report', AdminTotalReport::class)->name('admin-total-report');
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
        Route::get('/total-report', TotalReport::class)->name('total-report');
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

        Route::get('/table-noon-report', TableNoonReport::class)->name('table-noon-report');
        Route::get('/table-departure-report', TableDepartureReport::class)->name('table-departure-report');
        Route::get('/table-arrival-report', TableArrivalReport::class)->name('table-arrival-report');
        Route::get('/table-bunkering-report', TableBunkeringReport::class)->name('table-bunkering-report');
        Route::get('/table-all-fast-report', TableAllFastReport::class)->name('table-all-fast-report');
        Route::get('/table-weekly-schedule-report', TableWeeklyScheduleReport::class)->name('table-weekly-schedule-report');
        Route::get('/table-crew-monitoring-plan-report-on-board-crew', TableOnBoardCrew::class)->name('table-crew-monitoring-plan-report-on-board-crew');
        Route::get('/table-crew-monitoring-plan-report-crew-change', TableCrewChange::class)->name('table-crew-monitoring-plan-report-crew-change');
        Route::get('/table-voyage-report', TableVoyageReport::class)->name('table-voyage-report');
        Route::get('/table-kpi-report', TableKpiReport::class)->name('table-kpi-report');
        Route::get('/table-port-of-call-report', TablePortOfCallReport::class)->name('table-port-of-call-report');

        Route::get('/all-fast/{id}/edit', EditAllFastReport::class)->name('all-fast-report.edit');
        Route::get('/voyage/{id}/edit', EditVoyageReport::class)->name('voyage-report.edit');
    });

    Route::group(['middleware' => ['role:officer']], function () {
        // Reports Officer
        Route::get('/officer-total-report', OfficerTotalReport::class)->name('officer-total-report');
        Route::get('/officer-noon-report', OfficerNoonReport::class)->name('officer-noon-report');
        Route::get('/officer-departure-report', OfficerDepartureReport::class)->name('officer-departure-report');
        Route::get('/officer-arrival-report', OfficerArrivalReport::class)->name('officer-arrival-report');
        Route::get('/officer-bunkering-report', OfficerBunkeringReport::class)->name('officer-bunkering-report');
        Route::get('/officer-all-fast-report', OfficerAllFastReport::class)->name('officer-all-fast-report');
        Route::get('/officer-weekly-schedule-report', OfficerWeeklyScheduleReport::class)->name('officer-weekly-schedule-report');
        Route::get('/officer-crew-monitoring-plan-report-on-board-crew', OfficerOnBoardCrew::class)->name('officer-crew-monitoring-plan-report-on-board-crew');
        Route::get('/officer-crew-monitoring-plan-report-crew-change', OfficerCrewChange::class)->name('officer-crew-monitoring-plan-report-crew-change');
        Route::get('/officer-voyage-report', OfficerVoyageReport::class)->name('officer-voyage-report');
        Route::get('/officer-kpi-report', OfficerKpiReport::class)->name('officer-kpi-report');
        Route::get('/officer-port-of-call-report', OfficerPortOfCallReport::class)->name('officer-port-of-call-report');
    });
});

require __DIR__ . '/auth.php';
