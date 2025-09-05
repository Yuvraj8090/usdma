<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\AccidentalReportController;
 use App\Http\Controllers\Admin\DistrictUserController;

use App\Http\Controllers\Admin\DailyReportsFillableController;
use App\Http\Controllers\Admin\DailyReportController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\DistrictReportController;
use App\Http\Controllers\NavbarItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\Admin\AccidentalReportFillableController;
use App\Http\Controllers\Admin\DhamController;

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
    if (Auth::check()) {
        return redirect()->route('dashboard'); // Adjust this route name as needed
    }
    return redirect()->route('login'); // Adjust this route name as needed
});
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('/admin/clear-cache', [PageController::class, 'clearCache'])->name('admin.clear.cache');

    // Dashboard route
    Route::get('/admin/dashboard', [AnalyticsController::class, 'index'])->name('dashboard');

    // Admin routes group
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
           
    Route::resource('district-users', DistrictUserController::class);


            Route::resource('district-reports', DistrictReportController::class);

            Route::resource('daily_reports_fillable', DailyReportsFillableController::class);
            Route::resource('daily_reports', DailyReportController::class);

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

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
