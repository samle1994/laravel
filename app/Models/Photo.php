<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $table = 'photo';
    protected $fillable = [
        'photo',
        'name',
        'type',
        'act',
        'link',
        'is_status',
        'created_at',
        'updated_at',
    ];
}