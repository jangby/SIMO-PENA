<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // INI YANG KURANG: Daftarkan semua nama kolom yang boleh diisi
    protected $fillable = [
    'event_id', 'name', 'birth_place', 'phone', 'school_origin', 'address', 
    'certificate_file', 'status',
    'birth_date',    // <--- Baru
    'payment_proof',
    'presence_at'
];

    // Relasi ke tabel Events (agar kita tahu ini pendaftaran acara apa)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}