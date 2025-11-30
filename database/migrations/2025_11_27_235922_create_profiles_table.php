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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        // Hubungkan dengan tabel users
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('nia_ipnu')->nullable(); // Nomor Induk Anggota
        $table->string('phone')->nullable();
        $table->text('address')->nullable();
        $table->string('school_origin')->nullable(); // Asal Sekolah/Kampus
        $table->year('birth_year')->nullable(); // Tahun Lahir
        $table->enum('gender', ['L', 'P']); // L = Laki-laki (IPNU), P = Perempuan (IPPNU)
        $table->string('photo')->nullable(); // Foto Profil
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
