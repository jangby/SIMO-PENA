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
    // 1. Tabel Rundown / Jadwal
    Schema::create('event_schedules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('event_id')->constrained()->cascadeOnDelete();
        $table->time('start_time'); // Jam Mulai (08:00)
        $table->time('end_time');   // Jam Selesai (09:00)
        $table->string('activity'); // Nama Kegiatan
        $table->string('pic')->nullable(); // Penanggung Jawab / Pemateri
        $table->timestamps();
    });

    // 2. Tambah kolom 'presence_at' di tabel pendaftaran untuk Absensi
    Schema::table('registrations', function (Blueprint $table) {
        $table->dateTime('presence_at')->nullable()->after('status');
    });
}

public function down(): void
{
    Schema::dropIfExists('event_schedules');
    Schema::table('registrations', function (Blueprint $table) {
        $table->dropColumn('presence_at');
    });
}
};
