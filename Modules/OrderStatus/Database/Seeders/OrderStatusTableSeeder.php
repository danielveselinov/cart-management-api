<?php

namespace Modules\OrderStatus\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\OrderStatus\Entities\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $statuses = ['pending', 'preparing', 'on-route', 'delivered'];

        foreach ($statuses as $status) {
            OrderStatus::create(['status' => $status]);
        }
    }
}
