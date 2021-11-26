<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function order_products()
    {
        return $this->hasMany(Order_Product::class);
    }

    public function shop()
    {
            return $this->belongsTo(Shop::class);
    }
}
