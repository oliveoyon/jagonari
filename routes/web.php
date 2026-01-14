<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdmitCardController;
use App\Http\Controllers\Admin\GalleryEventController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobCircularController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('home-sliders', HomeSliderController::class);
        Route::resource('menus', MenuController::class);
        Route::post('menus/upload-image', [MenuController::class, 'uploadImage'])->name('menus.upload-image');
        Route::get('general-settings/edit', [GeneralSettingController::class, 'edit'])->name('general-settings.edit');
        Route::post('general-settings/update', [GeneralSettingController::class, 'update'])->name('general-settings.update');
        Route::resource('team-members', TeamMemberController::class)->names('team-members');


        Route::resource('job-circulars', JobCircularController::class)->names('job-circulars');
        Route::resource('job-applications', JobApplicationController::class)->names('job-applications');
        Route::get('job-applications/{id}/admit-card', [AdmitCardController::class, 'generate'])->name('job-applications.admit-card');

        Route::resource('gallery-events', GalleryEventController::class)->names('gallery-events');

        Route::resource('gallery-images', GalleryImageController::class)->names('gallery-images');

        // Bulk store route (same as store but for multiple files)
        Route::post('gallery-images/bulk-store', [GalleryImageController::class, 'bulkStore'])->name('gallery-images.bulk-store');
    });

require __DIR__ . '/auth.php';
