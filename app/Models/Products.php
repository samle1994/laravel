<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $fillable = [
        'photo',
        'name',
        'sku',
        'type',
        'price',
        'slug',
        'description',
        'content',
        'price',
        'id_list',
        'id_cat',
        'created_at',
        'updated_at',
    ];
    public function productList() {
        return $this->belongsTo('App\Models\ProductList', 'id_list');
    }
    public function productCat() {
        return $this->belongsTo('App\Models\ProductCat', 'id_cat');
    }
    public function files()
    {
        return $this->hasMany('App\Models\Gallery', 'id_list');
    }
}