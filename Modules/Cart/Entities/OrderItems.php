<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;

class OrderItems extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Cart\Database\factories\OrderItemsFactory::new();
    }

    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
