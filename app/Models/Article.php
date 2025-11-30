<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi ke Penulis (User)
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}