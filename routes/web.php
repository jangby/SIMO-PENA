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
use App\Http\Controllers\Admin\PanitiaAccountController;
use App\Http\Controllers\Panitia\MobileController;

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
    
    // --- FITUR EDIT ANGGOTA (WAJIB ADA UNTUK SINKRONISASI) ---
    Route::get('/admin/members/{user}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/admin/members/{user}', [MemberController::class, 'update'])->name('admin.members.update');
    // --------------------------------------------------------

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

    Route::resource('/admin/panitia', PanitiaAccountController::class)
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
        
        // Cetak ID Card Massal
        Route::get('/id-cards/print', [EventManagementController::class, 'printAllIdCards'])->name('idcards.print');
    });
});

/*
|--------------------------------------------------------------------------
| PANITIA ROUTES (Mobile App)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'panitia'])->prefix('panitia')->name('panitia.')->group(function () {
    
    // Dashboard & Menu Utama
    Route::get('/dashboard', [MobileController::class, 'index'])->name('dashboard');
    Route::get('/scan', [MobileController::class, 'scan'])->name('scan');
    Route::get('/attendance', [MobileController::class, 'attendance'])->name('attendance');

    // Proses Scan
    Route::post('/scan-process', [EventManagementController::class, 'scanQr'])->name('scan.process');

    // Detail Event
    Route::prefix('event/{id}')->group(function() {
        Route::get('/', [MobileController::class, 'show'])->name('event.show');
        Route::get('/participants', [MobileController::class, 'participants'])->name('event.participants');
        Route::get('/schedules', [MobileController::class, 'schedules'])->name('event.schedules');
        
        // Export PDF Rekap Utama
        Route::get('/export-pdf', [MobileController::class, 'exportPdf'])->name('event.export_pdf');
    });
    
    // Export PDF Per Materi
    Route::get('/schedule/{id}/export-pdf', [MobileController::class, 'exportSchedulePdf'])
        ->name('schedule.export_pdf');

});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| SCRIPT DIAGNOSA & PERBAIKAN DATA (Link by Email & Phone)
|--------------------------------------------------------------------------
*/
Route::get('/fix-data-v2', function () {
    $log = [];
    $log[] = "<h3>HASIL DIAGNOSA DATA:</h3>";

    // 1. AMBIL DATA YANG PUTUS HUBUNGAN (User ID NULL)
    $orphans = \App\Models\Registration::whereNull('user_id')->get();
    $log[] = "Ditemukan <b>" . $orphans->count() . "</b> pendaftaran yang tidak punya User ID (Putus Hubungan).<br>";

    $linkedCount = 0;
    foreach ($orphans as $reg) {
        $foundUser = null;
        $method = '';

        // A. Coba cari pakai Email
        $foundUser = \App\Models\User::where('email', $reg->email)->first();
        if ($foundUser) {
            $method = 'Email';
        } 
        // B. Jika gagal, cari pakai No HP (Lewat Profile)
        else {
            $profile = \App\Models\Profile::where('phone', $reg->phone)->first();
            if ($profile) {
                $foundUser = $profile->user;
                $method = 'No HP';
            }
        }

        // EKSEKUSI PENJODOHAN
        if ($foundUser) {
            $reg->update(['user_id' => $foundUser->id]);
            $linkedCount++;
            $log[] = "<span style='color:green'>✅ BERHASIL LINK ($method):</span> {$reg->name} -> Disambungkan ke User ID {$foundUser->id}";
        } else {
            $log[] = "<span style='color:red'>❌ GAGAL LINK:</span> {$reg->name} (Email: {$reg->email}, HP: {$reg->phone}) -> <b>Tidak ditemukan Akun Kader yang cocok.</b>";
        }
    }

    $log[] = "<hr><b>Total Berhasil Disambungkan: $linkedCount</b><br>";

    // 2. SINKRONISASI GENDER MASSAL (Hanya untuk yang sudah punya User ID)
    $log[] = "<h3>SINKRONISASI GENDER:</h3>";
    
    $allRegs = \App\Models\Registration::whereNotNull('user_id')->get();
    $syncCount = 0;

    foreach ($allRegs as $reg) {
        $user = \App\Models\User::find($reg->user_id);
        
        // Pastikan User & Profile ada
        if ($user && $user->profile) {
            $genderKader = $user->profile->gender; // Gender di Database Kader
            $genderEvent = $reg->gender;           // Gender di Event

            // Jika beda atau di event kosong, PAKSA UPDATE ikut data Kader
            if ($genderKader && ($genderEvent !== $genderKader)) {
                $reg->update([
                    'gender' => $genderKader,
                    'school_origin' => $user->profile->school_origin // Sekalian sekolahnya
                ]);
                $syncCount++;
                $log[] = "🔄 UPDATE DATA: <b>{$reg->name}</b> diubah menjadi " . ($genderKader=='L'?'IPNU':'IPPNU');
            }
        }
    }

    $log[] = "<br><b>Total Data Gender Diperbaiki: $syncCount</b>";

    return implode('<br>', $log);
});