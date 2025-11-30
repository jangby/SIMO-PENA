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
    // 1. Update tabel registrations (Formulir Pendaftaran)
    Schema::table('registrations', function (Blueprint $table) {
        $table->date('birth_date')->nullable()->after('name'); // Tambah Tanggal Lahir
        $table->string('payment_proof')->nullable()->after('address'); // Tambah Bukti Bayar
    });

    // 2. Update tabel profiles (Data Anggota)
    Schema::table('profiles', function (Blueprint $table) {
        // Hapus kolom tahun (birth_year)
        $table->dropColumn('birth_year');
        // Ganti jadi tanggal lengkap (birth_date)
        $table->date('birth_date')->nullable()->after('gender');
    });
}

public function down(): void
{
    // Kembalikan jika dibatalkan (Rollback)
    Schema::table('registrations', function (Blueprint $table) {
        $table->dropColumn(['birth_date', 'payment_proof']);
    });

    Schema::table('profiles', function (Blueprint $table) {
        $table->dropColumn('birth_date');
        $table->year('birth_year')->nullable();
    });
}
};
