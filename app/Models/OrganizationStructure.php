<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationStructure extends Model
{

    protected $fillable = ['organization_id', 'name', 'position', 'level', 'photo', 'department', 'instagram_link'];

    use HasFactory;
    protected $guarded = ['id'];
}