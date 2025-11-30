<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'banner',      // Path foto banner
        'type',        // makesta, lakmud, rapat, lainnya
        'status',      // open, closed, draft
        'price',
    ];

    // Casting agar otomatis jadi format tanggal Carbon
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relasi: Event punya banyak pendaftar
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function schedules()
    {
        return $this->hasMany(EventSchedule::class);
    }
}