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
    Schema::create('organization_structures', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Pengurus
        $table->string('position'); // Jabatan (Ketua, Sekretaris, dll)
        $table->string('department')->nullable(); // Departemen (BPH, Kaderisasi, dll)
        $table->string('photo')->nullable(); // Foto Resmi
        $table->integer('level')->default(99); // Urutan (1 = Ketua, 2 = Sekre, dst)
        $table->string('instagram_link')->nullable(); // Sosmed (Opsional)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_structures');
    }
};
