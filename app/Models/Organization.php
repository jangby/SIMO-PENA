<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $guarded = ['id']; // Izinkan mass assignment kecuali ID

    // Relasi: Satu Organisasi punya banyak Admin (User)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Relasi: Satu Organisasi punya banyak Anggota (Profile)
    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }
}