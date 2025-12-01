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
    Schema::table('event_schedules', function (Blueprint $table) {
        // Ubah dari TIME (08:00:00) menjadi DATETIME (2025-01-01 08:00:00)
        $table->dateTime('start_time')->change();
        $table->dateTime('end_time')->change();
    });
}

public function down(): void
{
    Schema::table('event_schedules', function (Blueprint $table) {
        $table->time('start_time')->change();
        $table->time('end_time')->change();
    });
}
};
