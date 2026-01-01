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
use App\Http\Controllers\TourController;
use App\Http\Controllers\PendaftaranController;

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
    $role = auth()->user()->role;
    
    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    elseif ($role === 'panitia') {
        return redirect()->route('panitia.dashboard');
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
    Route::get('/kegiatan-saya/{id}/sertifikat', [MyEventController::class, 'downloadCertificate'])->name('my-events.certificate.download');

    Route::post('/complete-tour', [TourController::class, 'complete'])->name('tour.complete');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'admin'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // 1. Data Anggota
    Route::get('/admin/members/export', [MemberController::class, 'export'])->name('admin.members.export');
    Route::get('/admin/members', [MemberController::class, 'index'])->name('admin.members.index');
    Route::get('/admin/members/{user}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/admin/members/{user}', [MemberController::class, 'update'])->name('admin.members.update');
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

    // Route Keuangan
    Route::get('/admin/finances', [FinanceController::class, 'index'])->name('admin.finances.index');
    Route::post('/admin/finances', [FinanceController::class, 'store'])->name('admin.finances.store');
    Route::get('/admin/finances/export', [FinanceController::class, 'export'])->name('admin.finances.export');
    Route::delete('/admin/finances/{finance}', [FinanceController::class, 'destroy'])->name('admin.finances.destroy');

    // 4. MANAJEMEN EVENT
    
    // Custom Routes Event
    Route::get('/admin/events/{event}/manage', [EventController::class, 'manage'])->name('admin.events.manage');
    Route::patch('/admin/events/{event}/update-status', [EventController::class, 'updateStatus'])->name('admin.events.status');
    
    // Aksi Member
    Route::patch('/admin/members/{user}/activate', [MemberController::class, 'activate'])->name('admin.members.activate');
    Route::patch('/admin/members/{user}/deactivate', [MemberController::class, 'deactivate'])->name('admin.members.deactivate');
    Route::patch('/admin/members/{user}/graduate', [MemberController::class, 'graduate'])->name('admin.members.graduate');
    Route::patch('/admin/members/{id}/restore', [MemberController::class, 'restore'])->name('admin.members.restore');
    Route::delete('/admin/members/{id}/force-delete', [MemberController::class, 'forceDelete'])->name('admin.members.force_delete');
    Route::delete('/admin/members/{user}', [MemberController::class, 'destroy'])->name('admin.members.destroy');

    // Resource Event
    Route::resource('/admin/events', EventController::class)->names([
        'index' => 'admin.events.index',
        'create' => 'admin.events.create',
        'store' => 'admin.events.store',
        'edit' => 'admin.events.edit',
        'update' => 'admin.events.update',
        'destroy' => 'admin.events.destroy',
    ]);

    Route::resource('/admin/panitia', \App\Http\Controllers\Admin\PanitiaAccountController::class)
        ->names('admin.panitia')
        ->except(['show', 'edit', 'update']);

    // Sub-Menu Event
    Route::prefix('admin/events/{event}')->name('admin.events.')->group(function () {
        // Data Peserta
        Route::get('/participants', [EventManagementController::class, 'participants'])->name('participants');
        Route::get('/participants/export', [EventManagementController::class, 'exportExcel'])->name('participants.export');
        Route::post('/participants/store', [EventManagementController::class, 'storeParticipant'])->name('participants.store');
        
        // QR Codes
        Route::get('/qr-codes', [EventManagementController::class, 'showQrCodes'])->name('qr.codes');
        Route::get('/qr-codes/{registration}/download', [EventManagementController::class, 'downloadQrCode'])->name('qr.download');
        
        // Jadwal (Rundown)
        Route::get('/schedules', [EventManagementController::class, 'schedules'])->name('schedules');
        Route::post('/schedules', [EventManagementController::class, 'storeSchedule'])->name('schedules.store');
        Route::delete('/schedules/{schedule}', [EventManagementController::class, 'destroySchedule'])->name('schedules.destroy');

        // Absensi
        Route::get('/attendance', [EventManagementController::class, 'attendance'])->name('attendance');
        Route::post('/attendance/{registration}/checkin', [EventManagementController::class, 'checkIn'])->name('attendance.checkin');
        Route::post('/attendance/{registration}/cancel', [EventManagementController::class, 'cancelCheckIn'])->name('attendance.cancel');
        Route::post('/scan-qr', [EventManagementController::class, 'scanQr'])->name('attendance.scan');
        Route::post('/certificate', [EventManagementController::class, 'uploadCertificate'])->name('certificate.upload');
        
        // Sertifikat
        Route::get('/certificates', [EventManagementController::class, 'certificates'])->name('certificates');
        Route::post('/certificates/{registration}', [EventManagementController::class, 'storeCertificate'])->name('certificates.store');
    });
});

/*
|--------------------------------------------------------------------------
| PANITIA ROUTES (Mobile App)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    
    // Dashboard & Menu Utama
    Route::get('/dashboard', [\App\Http\Controllers\Panitia\MobileController::class, 'index'])->name('dashboard');
    Route::get('/scan', [\App\Http\Controllers\Panitia\MobileController::class, 'scan'])->name('scan');
    Route::get('/attendance', [\App\Http\Controllers\Panitia\MobileController::class, 'attendance'])->name('attendance');

    // Proses Scan
    Route::post('/scan-process', [\App\Http\Controllers\Admin\EventManagementController::class, 'scanQr'])->name('scan.process');

    // Detail Event
    Route::prefix('event/{id}')->group(function() {
        Route::get('/', [\App\Http\Controllers\Panitia\MobileController::class, 'show'])->name('event.show');
        Route::get('/participants', [\App\Http\Controllers\Panitia\MobileController::class, 'participants'])->name('event.participants');
        Route::get('/schedules', [\App\Http\Controllers\Panitia\MobileController::class, 'schedules'])->name('event.schedules');
        
        // Export PDF Rekap Utama
        Route::get('/export-pdf', [\App\Http\Controllers\Panitia\MobileController::class, 'exportPdf'])->name('event.export_pdf');
    });
    
    // ===> PERBAIKAN ROUTE ERROR (DIPINDAH KE SINI) <===
    // Export PDF Per Materi (Sekarang otomatis jadi: panitia.schedule.export_pdf)
    Route::get('/schedule/{id}/export-pdf', [\App\Http\Controllers\Panitia\MobileController::class, 'exportSchedulePdf'])
        ->name('schedule.export_pdf');

});


// File: routes/web.php (Paling Bawah)

Route::get('/fix-gender-data', function() {
    // Ambil semua pendaftaran
    $registrations = \App\Models\Registration::all();
    $count = 0;

    foreach($registrations as $reg) {
        // Cari User & Profile pasangannya
        $user = \App\Models\User::find($reg->user_id);
        
        if ($user && $user->profile) {
            // Update gender di tabel registration sesuai data di profile
            $reg->update([
                'gender' => $user->profile->gender
            ]);
            $count++;
        }
    }

    return "Berhasil memperbaiki data gender untuk $count peserta. Silakan hapus route ini.";
});

require __DIR__.'/auth.php';