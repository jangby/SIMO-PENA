<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleAttendance extends Model
{
    use HasFactory;

    // INI YANG KURANG: Mendaftarkan kolom agar bisa diisi
    protected $fillable = [
        'registration_id',
        'event_schedule_id',
        'scanned_at'
    ];

    // Relasi ke Registration (Peserta)
    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    // Relasi ke EventSchedule (Jadwal)
    public function schedule()
    {
        return $this->belongsTo(EventSchedule::class, 'event_schedule_id');
    }
}