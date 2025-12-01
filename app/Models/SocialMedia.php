<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    use HasFactory;
    
    // TAMBAHKAN INI: Memberi tahu Laravel nama tabel yang benar
    protected $table = 'social_medias'; 

    protected $fillable = ['platform', 'url'];
}