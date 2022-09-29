<?php

namespace Modules\Cart\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\Entities\Order;
use Modules\Product\Entities\Product;

class OrderItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Cart\Entities\OrderItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_id' => Order::factory()->create(),
            'product_id' => Product::factory()->create(),
            'qty' => 2,
            'price' => 2 * 2
        ];
    }
}

