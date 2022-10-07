<?php

namespace Modules\PaymentType\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\PaymentType\Database\factories\PaymentTypeFactory::new();
    }
}
