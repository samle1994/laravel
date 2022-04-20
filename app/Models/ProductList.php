<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;

    protected $table = 'product_list';
    protected $fillable = [
        'name',
        'type',
        'slug',
        'created_at',
        'updated_at',
    ];
}