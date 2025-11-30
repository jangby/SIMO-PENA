<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom di tabel pendaftaran
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('birth_place')->nullable()->after('name'); 
        });

        // 2. Tambah kolom di tabel profil anggota
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('birth_place')->nullable()->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('birth_place');
        });

        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('birth_place');
        });
    }
};