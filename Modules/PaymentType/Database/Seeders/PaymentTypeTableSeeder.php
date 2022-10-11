<?php

namespace Modules\PaymentType\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\PaymentType\Entities\PaymentType;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $payments = [
            'cash on delivery' => 'cashOnDelivery',
            'card on delivery' => 'cardOnDelivery',
            'online payment' => 'online'
        ];

        foreach ($payments as $name => $type) {
            PaymentType::create(['name' => $name, 'type' => $type]);
        }
    }
}
