<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\AccidentalReportController;
use App\Http\Controllers\Admin\DistrictUserController;
use App\Http\Controllers\Admin\DailyReportDhamController;
use App\Http\Controllers\Admin\DailyReportsFillableController;
use App\Http\Controllers\Admin\DailyReportFileController;
use App\Http\Controllers\Admin\RoadClosedFillableController;
use App\Http\Controllers\Admin\RoadClosedReportController;
use App\Http\Controllers\Admin\DailyReportController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DistrictReportController;
use App\Http\Controllers\NavbarItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Admin\AccidentalReportFillableController;
use App\Http\Controllers\Admin\DhamController;
use App\Http\Controllers\Admin\MeetingController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ManpowerController;
use App\Http\Controllers\ReliefMaterialController;
use App\Http\Controllers\DeploymentController;
use App\Http\Controllers\Admin\EquipmentCategoryController;
use App\Http\Controllers\Admin\SeasonController;

Route::get('/en/{slug}', [PageController::class, 'showPage'])->name('page.show');
Route::get('/hi/{slug}', [PageController::class, 'showPageHi'])->name('page.show.hi');
Route::get('/{lang}/{slug}', [PageController::class, 'showLocalizedPage'])
    ->where(['lang' => 'en|hi'])
    ->name('pages.localized');
Route::get('/{lang}', [PageController::class, 'showWelcomePage'])
    ->where('lang', 'en|hi')
    ->name('welcome.localized');
Route::get('/', [PageController::class, 'showWelcomePage'])->name('welcome');
Route::get('/admin', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/admin/clear-cache', [PageController::class, 'clearCache'])->name('admin.clear.cache');
    Route::get('admin/daily-reports-dhams/pdf', [DailyReportDhamController::class, 'downloadPdf'])->name('admin.daily_reports_dhams.pdf');
  Route::resource('tourist-visitor-details', App\Http\Controllers\Admin\TouristVisitorDetailController::class);


    // Dashboard route
    Route::get('/admin/dashboard', [AnalyticsController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->group(function () {
        Route::get('/reports', [DailyReportFileController::class, 'index'])->name('admin.reports.index');
        Route::post('/reports', [DailyReportFileController::class, 'store'])->name('admin.reports.store');
    });

    // Admin routes group
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::resource('relief_material', ReliefMaterialController::class);
            Route::resource('seasons', SeasonController::class);

            Route::resource('natural-disaster-reports', App\Http\Controllers\Admin\NaturalDisasterReportController::class);

            Route::resource('natural-disaster-fillable', App\Http\Controllers\Admin\NaturalDisasterReportsFillableController::class)
                ->names('natural-disaster-fillable')
                ->parameters(['natural-disaster-fillable' => 'fillable']);

            Route::resource('manpower', ManpowerController::class);

            Route::resource('district-users', DistrictUserController::class);

            // ================== 🛣️ Road Closed Fillable (Category Master) ==================
            Route::resource('road-closed-fillable', RoadClosedFillableController::class)->names([
                'index' => 'road-closed-fillable.index',
                'create' => 'road-closed-fillable.create',
                'store' => 'road-closed-fillable.store',
                'edit' => 'road-closed-fillable.edit',
                'update' => 'road-closed-fillable.update',
                'destroy' => 'road-closed-fillable.destroy',
            ]);

            // ================== 🚧 Road Closed Reports ==================
            Route::resource('road-closed-reports', RoadClosedReportController::class)->names([
                'index' => 'road-closed-reports.index',
                'create' => 'road-closed-reports.create',
                'store' => 'road-closed-reports.store',
                'edit' => 'road-closed-reports.edit',
                'update' => 'road-closed-reports.update',
                'destroy' => 'road-closed-reports.destroy',
            ]);

            Route::resource('deployments', DeploymentController::class);

            Route::resource('equipment_categories', EquipmentCategoryController::class);

            Route::resource('equipment', EquipmentController::class);

            // Meeting CRUD routes
            Route::resource('meetings', MeetingController::class);

            // Daily Reports for Dhams
            Route::resource('district-reports', DistrictReportController::class);

            Route::resource('daily_reports_fillable', DailyReportsFillableController::class);
            Route::resource('daily_reports', DailyReportController::class);
            Route::resource('daily_reports_dhams', DailyReportDhamController::class);
            Route::delete('daily_reports_dhams/{daily_reports_dham}/force', [DailyReportDhamController::class, 'forceDestroy'])->name('daily_reports_dhams.forceDestroy');
            Route::resource('districts', DistrictController::class);

            Route::resource('accidental_reports', AccidentalReportController::class);

            Route::resource('dhams', DhamController::class);

            Route::resource('states', StateController::class);

            Route::resource('accidental-reports-fillable', AccidentalReportFillableController::class);

            Route::resource('media-files', App\Http\Controllers\Admin\MediaFileController::class);
            Route::get('media-files/{mediaFile}/download', [App\Http\Controllers\Admin\MediaFileController::class, 'download'])->name('media-files.download');

            Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);
            Route::resource('navbar-items', NavbarItemController::class);
            Route::post('navbar-items/update-order', [NavbarItemController::class, 'updateOrder'])->name('navbar-items.update-order');

            Route::get('/pages', [PageController::class, 'listPages'])->name('pages.list');
            Route::get('/pages/create', [PageController::class, 'showCreateForm'])->name('pages.create.form');
            Route::post('/pages/create', [PageController::class, 'createPage'])->name('pages.create');
            Route::get('/pages/edit/{id}', [PageController::class, 'showEditForm'])->name('pages.edit.form');
            Route::put('/pages/edit/{id}', [PageController::class, 'updatePage'])->name('pages.update');
            Route::post('/pages/delete/{id}', [PageController::class, 'deletePage'])->name('pages.delete');

            // CRUD routes for Roles and Users under /admin
            Route::resource('roles', RoleController::class);
            Route::resource('users', UserController::class);
        });
});
