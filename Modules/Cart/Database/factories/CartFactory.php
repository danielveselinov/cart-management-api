<?php

namespace Modules\Cart\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Address\Entities\Address;
use Modules\PaymentType\Entities\PaymentType;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Cart\Entities\Cart::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'address_id' => Address::factory(),
            'payment_type_id' => PaymentType::factory()
        ];
    }
}

