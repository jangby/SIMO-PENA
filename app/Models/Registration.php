<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id', 
        'name',
        'gender',        // <--- PERBAIKAN: Kolom ini WAJIB ada disini agar bisa disimpan
        'birth_place', 
        'birth_date',    // Pastikan urutannya rapi (opsional, tapi memudahkan pengecekan)
        'phone', 
        'school_origin', 
        'address', 
        'certificate_file', 
        'status',
        'payment_proof',
        'presence_at'
    ];

    // Relasi ke tabel Events
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Relasi ke tabel Users
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