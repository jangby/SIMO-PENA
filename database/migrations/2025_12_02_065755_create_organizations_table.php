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
    Schema::create('organizations', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Contoh: PR Desa Limbangan Timur
        $table->enum('type', ['PAC', 'PR', 'PK']); // Tingkatan
        $table->text('address')->nullable();
        $table->string('logo')->nullable(); // Logo khusus PR/PK (jika ada)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
