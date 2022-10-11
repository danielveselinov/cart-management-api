<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected static function newFactory()
    {
        return \Modules\City\Database\factories\CityFactory::new();
    }
}
