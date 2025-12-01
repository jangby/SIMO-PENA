<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\PublicEventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\RegistrationApprovalController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LetterController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\SocialMediaController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Member\MyEventController;
use App\Http\Controllers\Member\ArticleController as MemberArticleController;
use App\Http\Controllers\Member\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes (Public & Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [PublicEventController::class, 'index'])->name('welcome');
Route::get('/berita/{slug}', [PublicEventController::class, 'showArticle'])->name('public.article.show');
Route::get('/daftar/{event}', [PublicEventController::class, 'showRegisterForm'])->name('event.register');
Route::post('/daftar/{event}', [PublicEventController::class, 'store'])->name('event.store');
Route::get('/dokumentasi', [PublicEventController::class, 'gallery'])->name('public.gallery');
Route::get('/dokumentasi/download/{id}', [PublicEventController::class, 'downloadOriginal'])->name('public.gallery.download');
Route::get('/struktur-organisasi', [PublicEventController::class, 'structure'])->name('public.structure');

/*
|--------------------------------------------------------------------------
| Dashboard Redirect Logic
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Member Routes (Login Required)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Biodata
    Route::get('/biodata', [BiodataController::class, 'edit'])->name('biodata.edit');
    Route::patch('/biodata', [BiodataController::class, 'update'])->name('biodata.update');

    // Kegiatan Saya
    Route::get('/kegiatan-saya', [MyEventController::class, 'index'])->name('my-events.index');
    Route::get('/kegiatan-saya/{id}', [MyEventController::class, 'show'])->name('my-events.show');
    Route::get('/kegiatan-saya/{id}/id-card', [MyEventController::class, 'idCard'])->name('my-events.id-card');

    // Artikel Member
    Route::get('/kabar-ipnu', [MemberArticleController::class, 'index'])->name('member.articles.index');
    Route::get('/kabar-ipnu/{slug}', [MemberArticleController::class, 'show'])->name('member.articles.show');

    // Absensi
    Route::get('/absensi', [AttendanceController::class, 'index'])->name('member.attendance.index');
    Route::get('/absensi/{id}', [AttendanceController::class, 'show'])->name('member.attendance.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 1. Data Anggota (Export harus di atas resource agar tidak tertimpa)
    Route::get('/admin/members/export', [MemberController::class, 'export'])->name('admin.members.export');
    Route::get('/admin/members', [MemberController::class, 'index'])->name('admin.members.index');
    Route::get('/admin/members/{user}', [MemberController::class, 'show'])->name('admin.members.show');

    // 2. Pendaftaran Masuk
    Route::get('/admin/registrations', [RegistrationApprovalController::class, 'index'])->name('admin.registrations.index');
    Route::get('/admin/registrations/{registration}', [RegistrationApprovalController::class, 'show'])->name('admin.registrations.show');
    Route::post('/admin/registrations/{registration}/approve', [RegistrationApprovalController::class, 'approve'])->name('admin.registrations.approve');
    Route::post('/admin/registrations/{registration}/reject', [RegistrationApprovalController::class, 'reject'])->name('admin.registrations.reject');

    // 3. Manajemen Konten & Data Lain
    Route::resource('/admin/articles', ArticleController::class)->names('admin.articles');
    Route::get('/admin/galleries/sync', [GalleryController::class, 'syncGoogleDrive'])->name('admin.galleries.sync');
    Route::resource('/admin/galleries', GalleryController::class)->names('admin.galleries');
    Route::resource('/admin/letters', LetterController::class)->names('admin.letters');
    Route::resource('/admin/structures', StructureController::class)->names('admin.structures');
    Route::resource('/admin/socials', SocialMediaController::class)->only(['index', 'store', 'destroy'])->names('admin.socials');
    
    // Route Keuangan Lengkap
    Route::get('/admin/finances', [FinanceController::class, 'index'])->name('admin.finances.index');
    Route::post('/admin/finances', [FinanceController::class, 'store'])->name('admin.finances.store'); // Simpan
    Route::get('/admin/finances/export', [FinanceController::class, 'export'])->name('admin.finances.export'); // Export
    Route::delete('/admin/finances/{finance}', [FinanceController::class, 'destroy'])->name('admin.finances.destroy'); // Hapus

    // 4. MANAJEMEN EVENT (Complex Routes)
    
    // A. Custom Routes Event (Harus di luar prefix group '{event}')
    Route::get('/admin/events/{event}/manage', [EventController::class, 'manage'])->name('admin.events.manage');
    Route::patch('/admin/events/{event}/update-status', [EventController::class, 'updateStatus'])->name('admin.events.status');
    Route::patch('/admin/members/{user}/activate', [MemberController::class, 'activate'])->name('admin.members.activate');

    // B. Resource Event
    Route::resource('/admin/events', EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);

    // C. Sub-Menu Event (Participants, Schedules, Attendance)
    // Prefix ini otomatis menambahkan '/admin/events/{event}' ke semua URL di bawahnya
    Route::prefix('admin/events/{event}')->name('admin.events.')->group(function () {
        
        // Data Peserta
        Route::get('/participants', [EventManagementController::class, 'participants'])->name('participants');
        Route::get('/participants/export', [EventManagementController::class, 'exportExcel'])->name('participants.export');
        Route::get('/print-idcards', [EventManagementController::class, 'printAllIdCards'])->name('print.idcards');
        
        // Jadwal (Rundown)
        Route::get('/schedules', [EventManagementController::class, 'schedules'])->name('schedules');
        Route::post('/schedules', [EventManagementController::class, 'storeSchedule'])->name('schedules.store');
        Route::delete('/schedules/{schedule}', [EventManagementController::class, 'destroySchedule'])->name('schedules.destroy');

        // Absensi
        Route::get('/attendance', [EventManagementController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/{registration}/checkin', [EventManagementController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/{registration}/cancel', [EventManagementController::class, 'cancelCheckIn'])->name('attendance.cancel');
        Route::post('/scan-qr', [EventManagementController::class, 'scanQr'])->name('attendance.scan');
    });
});

require __DIR__.'/auth.php';