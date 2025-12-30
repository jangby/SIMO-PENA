<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',       // <--- PENTING: Tambahkan ini agar ID User tersimpan
        'event_id', 
        'name', 
        'birth_place', 
        'phone', 
        'school_origin', 
        'address', 
        'certificate_file', 
        'status',
        'birth_date',
        'payment_proof',
        'presence_at'
    ];

    // Relasi ke tabel Events
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke tabel Users (INI YANG SEBELUMNYA HILANG)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke absensi per materi
public function scheduleAttendances()
{
    return $this->hasMany(ScheduleAttendance::class);
}
}