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
        Schema::table('registrations', function (Blueprint $table) {
            // Menambahkan kolom user_id setelah event_id
            // Dibuat nullable dulu untuk mencegah error pada data lama
            $table->foreignId('user_id')
                  ->nullable() 
                  ->after('event_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Hapus foreign key dan kolom jika di-rollback
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};