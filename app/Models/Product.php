<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'paroducts';
    protected $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock_quantity'
    ];

    protected $casts = [
        'price' => 'double',
        'stock_quantity' => 'integer'
    ];
}
