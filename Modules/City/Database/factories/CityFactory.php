<?php

namespace Modules\City\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Country\Entities\Country;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\City\Entities\City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->city(),
            'country_id' => Country::factory()
        ];
    }
}

