<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Product\Entities\Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->sentence(),
            'category_id' => rand(1, 10),
            'description' => fake()->text(350),
            'final_price' => fake()->randomFloat(2, 0, 9999),
        ];
    }
}

