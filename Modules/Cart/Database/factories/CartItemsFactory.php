<?php

namespace Modules\Cart\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\Entities\Cart;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;

class CartItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Cart\Entities\CartItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cart_id' => Cart::factory(),
            'product_id' => Product::factory()->for(Category::factory()->create()),
            'qty' => rand(1, 9)
        ];
    }
}

