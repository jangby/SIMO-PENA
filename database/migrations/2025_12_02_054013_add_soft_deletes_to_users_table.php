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
    Schema::table('users', function (Blueprint $table) {
        $table->softDeletes(); // Menambahkan kolom deleted_at
    });

    // Kita ubah kolom grade di tabel profiles agar menerima value 'alumni'
    // Catatan: Mengubah ENUM di Laravel kadang butuh raw query agar aman
    DB::statement("ALTER TABLE profiles MODIFY COLUMN grade ENUM('calon', 'anggota', 'kader', 'alumni') DEFAULT 'calon'");
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
};
