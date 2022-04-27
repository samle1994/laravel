<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'setting';
    protected $fillable = [
        'name',
        'email',
        'hotline',
        'website',
        'copyright',
        'title',
        'keywords',
        'description',
        'created_at',
        'updated_at',
    ];
}