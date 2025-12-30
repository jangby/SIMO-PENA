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
    Schema::create('schedule_attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('registration_id')->constrained('registrations')->onDelete('cascade');
        $table->foreignId('event_schedule_id')->constrained('event_schedules')->onDelete('cascade');
        $table->timestamp('scanned_at'); // Waktu scan
        $table->timestamps();
        
        // Mencegah duplikasi absen di materi yang sama
        $table->unique(['registration_id', 'event_schedule_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_attendances');
    }
};
