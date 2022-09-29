<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class CartItems extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Cart\Database\factories\CartItemsFactory::new();
    }

    protected $guarded = [];
    
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
