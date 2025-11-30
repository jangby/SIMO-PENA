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
    Schema::create('letters', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['incoming', 'outgoing']); // Masuk / Keluar

        // Kolom Khusus Surat Keluar (Untuk Auto Number)
        $table->integer('index_number')->nullable(); // No Urut (misal: 1)
        $table->string('letter_code')->nullable(); // Kode (misal: A, B, SPA, SP)

        $table->string('reference_number'); // Nomor Surat Full String
        $table->date('letter_date'); // Tanggal Surat

        $table->string('sender')->nullable(); // Pengirim (Untuk Surat Masuk)
        $table->string('recipient')->nullable(); // Tujuan (Untuk Surat Keluar)

        $table->string('subject'); // Perihal
        $table->text('description')->nullable(); // Ringkasan
        $table->string('file_path')->nullable(); // Scan File

        $table->foreignId('user_id')->constrained(); // Siapa yang menginput
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('letters');
    }
};
