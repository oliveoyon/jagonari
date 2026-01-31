<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdmitCardController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\GalleryEventController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobCircularController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage symlink created successfully!';
});

Route::get('/', [WebController::class, 'home']);
Route::get('/contact', [WebController::class, 'contact']);
Route::post('/contact', [WebController::class, 'storeContact'])->name('contact.store');

Route::get('/jobs', [WebController::class, 'jobList'])->name('web.jobs.list');
Route::get('/jobs/{slug}', [WebController::class, 'jobDetail'])->name('web.jobs.detail');
Route::post('/jobs/{slug}/apply', [WebController::class, 'applyJob'])->name('web.jobs.apply');
Route::get('/gallery', [WebController::class, 'galleryEvents'])->name('gallery.events');

Route::get('/gallery/event/{slug}', [WebController::class, 'galleryByEvent'])
    ->name('gallery.event.images');
Route::get('/notice-board', [WebController::class, 'noticeBoard'])->name('notice.board');
Route::get('/notice-board/{id}', [WebController::class, 'noticeDetail'])->name('notice.detail');


// Dynamic page route (catch-all) - keep at the bottom
Route::get('/{slug}', [WebController::class, 'showPage'])
    ->where('slug', '^(?!login|register|password|dashboard|admin|storage-link|contact|jobs|gallery|notice-board).*$')
    ->name('dynamic.page');




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
        Route::post('gallery-images/bulk-store', [GalleryImageController::class, 'bulkStore'])->name('gallery-images.bulk-store');

        Route::get('contact-messages', [ContactMessageController::class, 'index'])
            ->name('contact-messages.index');

        Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])
            ->name('contact-messages.show');

        Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])
            ->name('contact-messages.destroy');
        
        Route::resource('notices', NoticeController::class);
    });

require __DIR__ . '/auth.php';
