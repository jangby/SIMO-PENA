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
            // 1. Kita cek dulu, kalau user_id belum ada, kita buatkan sekarang.
            // Ini penting karena Model Registration kamu butuh 'user_id'
            if (!Schema::hasColumn('registrations', 'user_id')) {
                $table->foreignId('user_id')
                      ->nullable()
                      ->after('id') // Taruh di awal setelah ID
                      ->constrained()
                      ->cascadeOnDelete();
            }

            // 2. Baru kita buat organization_id
            // Kita taruh after('event_id') saja biar aman (karena event_id pasti ada)
            $table->foreignId('organization_id')
                  ->nullable()
                  ->after('event_id') 
                  ->constrained()
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            // Hapus organization_id
            if (Schema::hasColumn('registrations', 'organization_id')) {
                $table->dropForeign(['organization_id']);
                $table->dropColumn('organization_id');
            }
            
            // Opsional: Hapus user_id jika ingin rollback bersih
            if (Schema::hasColumn('registrations', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};