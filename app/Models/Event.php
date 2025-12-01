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
        'banner',
        'type',
        'status',
        'price',
        'bank_accounts', // <--- Tambahkan ini
        'certificate_link',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'bank_accounts' => 'array', // <--- PENTING: Cast ke array
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