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
    Schema::create('finances', function (Blueprint $table) {
        $table->id();
        $table->enum('type', ['income', 'expense']); // Pemasukan / Pengeluaran
        $table->decimal('amount', 15, 2); // Jumlah Uang
        $table->string('description'); // Keterangan (Misal: Pendaftaran Si Fulan)
        $table->date('date'); // Tanggal Transaksi

        // Relasi opsional ke Event (biar tau ini uang dari acara apa)
        $table->foreignId('event_id')->nullable()->constrained()->onDelete('set null');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finances');
    }
};
