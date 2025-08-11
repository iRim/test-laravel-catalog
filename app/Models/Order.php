<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'customer_name',
        'customer_email',
        'total_amount'
    ];
    protected $casts = [
        'total_amount' => 'double'
    ];

    public function products()
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot('quantity');
    }
}
