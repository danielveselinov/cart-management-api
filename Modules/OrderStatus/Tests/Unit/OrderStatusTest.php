<?php

namespace Modules\OrderStatus\Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Cart\Entities\Order;

class OrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_order_statuses()
    {
        Sanctum::actingAs(User::factory()->create(['is_active' => 1, 'role' => 2]));
        $this
            ->getJson(route('order.statuses'))
            ->assertOk();
    }

    public function test_default_user_cant_access_order_statuses()
    {
        $this
            ->getJson(route('order.statuses'))
            ->assertUnauthorized();
    }

    public function test_update_order_status()
    {
        Sanctum::actingAs(User::factory()->create(['is_active' => 1, 'role' => 2]));

        $order = Order::factory()->create(['id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);
        $this
            ->putJson(route('order.status.update', $order->id), [
                'order_status_id' => 2
            ])->assertOk();
    }

    public function test_default_user_cant_update_order_statuses()
    {
        $order = Order::factory()->create(['id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);
        $this
            ->putJson(route('order.status.update', $order->id), [
                'order_status_id' => 2
            ])->assertUnauthorized();
    }
}
