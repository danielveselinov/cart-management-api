<?php

namespace Modules\Cart\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Modules\Cart\Database\factories\OrderFactory::new();
    }

    protected $guarded = [];
    
    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
}
