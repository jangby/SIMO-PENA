<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Hapus 'certificate_link' dari tabel events (Hanya jika kolomnya ada)
        if (Schema::hasColumn('events', 'certificate_link')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropColumn('certificate_link');
            });
        }

        // 2. Tambah 'certificate_file' ke registrations (Hanya jika BELUM ada)
        if (!Schema::hasColumn('registrations', 'certificate_file')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->string('certificate_file')->nullable()->after('presence_at');
            });
        }
    }

    public function down(): void
    {
        // Rollback logic (Kebalikannya)
        
        // Kembalikan kolom ke events
        if (!Schema::hasColumn('events', 'certificate_link')) {
            Schema::table('events', function (Blueprint $table) {
                $table->string('certificate_link')->nullable();
            });
        }

        // Hapus kolom dari registrations (Hati-hati, ini akan menghapus data sertifikat yg ada)
        // Sebaiknya kita biarkan saja atau komen bagian ini agar data aman saat rollback
        /*
        if (Schema::hasColumn('registrations', 'certificate_file')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('certificate_file');
            });
        }
        */
    }
};