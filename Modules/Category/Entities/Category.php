<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Category\Database\factories\CategoryFactory;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
    
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
