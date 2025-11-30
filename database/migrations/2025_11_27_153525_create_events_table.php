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
    Schema::create('events', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Nama Kegiatan (misal: Makesta Raya)
        $table->text('description'); // Deskripsi
        $table->string('location'); // Tempat
        $table->dateTime('start_time'); // Waktu Mulai
        $table->dateTime('end_time'); // Waktu Selesai
        $table->string('banner')->nullable(); // Foto Poster/Banner
        
        // Jenis Kegiatan: makesta, lakmud, rapat, lain
        $table->enum('type', ['makesta', 'lakmud', 'rapat', 'lainnya']); 
        
        // Status Pendaftaran: open (buka), closed (tutup), draft (konsep)
        $table->enum('status', ['open', 'closed', 'draft'])->default('draft');
        
        $table->decimal('price', 10, 2)->default(0); // Biaya pendaftaran (0 kalo gratis)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
