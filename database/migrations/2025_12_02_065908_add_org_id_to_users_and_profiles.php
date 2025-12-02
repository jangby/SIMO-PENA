<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // 1. Tambah ke tabel USERS (Untuk Admin Lokal)
    Schema::table('users', function (Blueprint $table) {
        // Nullable karena Super Admin PAC mungkin tidak terikat ranting tertentu, atau bisa diset ke ID PAC
        $table->foreignId('organization_id')->nullable()->after('role')->constrained('organizations')->onDelete('set null');
    });

    // 2. Tambah ke tabel PROFILES (Untuk Anggota)
    Schema::table('profiles', function (Blueprint $table) {
        $table->foreignId('organization_id')->nullable()->after('user_id')->constrained('organizations')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['organization_id']);
        $table->dropColumn('organization_id');
    });

    Schema::table('profiles', function (Blueprint $table) {
        $table->dropForeign(['organization_id']);
        $table->dropColumn('organization_id');
    });
}
};
