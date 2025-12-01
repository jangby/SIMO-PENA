<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\Admin\RegistrationApprovalController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\Member\MyEventController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Member\ArticleController as MemberArticleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Member\AttendanceController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\SocialMediaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PublicEventController::class, 'index'])->name('welcome');
Route::get('/berita/{slug}', [PublicEventController::class, 'showArticle'])->name('public.article.show'); // <--- Route Baru
Route::get('/daftar/{event}', [PublicEventController::class, 'showRegisterForm'])->name('event.register');
Route::post('/daftar/{event}', [PublicEventController::class, 'store'])->name('event.store');
Route::get('/', [PublicEventController::class, 'index'])->name('welcome');
Route::get('/berita/{slug}', [PublicEventController::class, 'showArticle'])->name('public.article.show');
Route::get('/dokumentasi', [PublicEventController::class, 'gallery'])->name('public.gallery'); // <--- Route Baru
Route::get('/dokumentasi/download/{id}', [PublicEventController::class, 'downloadOriginal'])->name('public.gallery.download');
Route::get('/struktur-organisasi', [PublicEventController::class, 'structure'])->name('public.structure');

Route::get('/dashboard', function () {
    // LOGIKA TAMBAHAN:
    // Jika user yang login ternyata ROLE-nya ADMIN,
    // Jangan biarkan dia masuk ke dashboard member biasa.
    // Tendang dia ke Dashboard Admin.
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // Jika member biasa, baru boleh masuk sini
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Biodata Member
    Route::get('/biodata', [BiodataController::class, 'edit'])->name('biodata.edit');
    Route::patch('/biodata', [BiodataController::class, 'update'])->name('biodata.update');
    // KEGIATAN SAYA
    Route::get('/kegiatan-saya', [MyEventController::class, 'index'])->name('my-events.index');
    Route::get('/kegiatan-saya/{id}', [MyEventController::class, 'show'])->name('my-events.show');
    Route::get('/kegiatan-saya/{id}/id-card', [MyEventController::class, 'idCard'])->name('my-events.id-card');

    Route::get('/kabar-ipnu', [MemberArticleController::class, 'index'])->name('member.articles.index');
    Route::get('/kabar-ipnu/{slug}', [MemberArticleController::class, 'show'])->name('member.articles.show');

    Route::get('/absensi', [AttendanceController::class, 'index'])->name('member.attendance.index');
    Route::get('/absensi/{id}', [AttendanceController::class, 'show'])->name('member.attendance.show');
});

// Perhatikan penambahan kata 'admin' di dalam kurung siku
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/admin/members/export', [MemberController::class, 'export'])->name('admin.members.export');
    Route::get('/admin/members', [MemberController::class, 'index'])->name('admin.members.index');
    Route::get('/admin/members/{user}', [MemberController::class, 'show'])->name('admin.members.show');
    Route::get('/admin/registrations', [RegistrationApprovalController::class, 'index'])->name('admin.registrations.index');
Route::get('/admin/registrations/{registration}', [RegistrationApprovalController::class, 'show'])->name('admin.registrations.show');
Route::post('/admin/registrations/{registration}/approve', [RegistrationApprovalController::class, 'approve'])->name('admin.registrations.approve');
Route::resource('/admin/articles', ArticleController::class)->names('admin.articles');
Route::get('/admin/galleries/sync', [GalleryController::class, 'syncGoogleDrive'])->name('admin.galleries.sync');
Route::resource('/admin/galleries', GalleryController::class)->names('admin.galleries');
Route::resource('/admin/letters', LetterController::class)->names('admin.letters');
Route::resource('/admin/structures', StructureController::class)->names('admin.structures');
Route::resource('/admin/socials', SocialMediaController::class)->only(['index', 'store', 'destroy'])->names('admin.socials');

// Resource Route otomatis membuat route index, create, store, destroy, dll
    Route::get('/admin/events/{event}/manage', [EventController::class, 'manage'])->name('admin.events.manage');
    Route::patch('/{event}/update-status', [EventController::class, 'updateStatus'])->name('admin.events.status');

    // Route Resource (CRUD)
    Route::resource('/admin/events', EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'edit' => 'admin.events.edit',     // <-- Pastikan ini ada otomatis
        'update' => 'admin.events.update', // <-- Pastikan ini ada otomatis
        'destroy' => 'admin.events.destroy',
    ]);

    // Grouping Menu Kelola Kegiatan
    Route::prefix('admin/events/{event}')->name('admin.events.')->group(function () {
        // Data Peserta
        Route::get('/participants', [EventManagementController::class, 'participants'])->name('participants');
        Route::patch('/{event}/update-status', [EventController::class, 'updateStatus'])->name('admin.events.status');
        
        // Jadwal (Rundown)
        Route::get('/schedules', [EventManagementController::class, 'schedules'])->name('schedules');
        Route::post('/schedules', [EventManagementController::class, 'storeSchedule'])->name('schedules.store');
        Route::delete('/schedules/{schedule}', [EventManagementController::class, 'destroySchedule'])->name('schedules.destroy');

        // Absensi
        Route::get('/attendance', [EventManagementController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/{registration}/checkin', [EventManagementController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/{registration}/cancel', [EventManagementController::class, 'cancelCheckIn'])->name('attendance.cancel');
        Route::post('/scan-qr', [EventManagementController::class, 'scanQr'])->name('attendance.scan');

        Route::get('/participants/export', [EventManagementController::class, 'exportExcel'])->name('participants.export');
    });
});

require __DIR__.'/auth.php';
