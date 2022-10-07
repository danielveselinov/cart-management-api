<?php

namespace Modules\Address\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\City\Entities\City;
use Modules\Country\Entities\Country;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Address\Entities\Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'country_id' => Country::factory(),
            'city_id' => City::factory(),
            'area' => fake()->city(),
            'street' => fake()->streetName(),
            'building' => fake()->buildingNumber(),
            'apratment' => fake()->randomNumber(),
            'landmark' => fake()->text(120),
            'is_main' => fake()->boolean()
        ];
    }
}

