<?php

namespace Modules\Cart\Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Cart\Entities\Cart;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_cart_and_add_cart_items()
    {
        Sanctum::actingAs(User::factory()->create());
        $cart = Cart::factory()->make();

        $this->postJson(route('cart.item.store'), [
            'cart_id' => $cart->id,
            'product_id' => 1,
            'qty' => 1
        ])->assertCreated();
    }

    public function test_unauthenticated_user_try_to_add_cart_items_to_a_cart_throws_an_error()
    {
        $cart = Cart::factory()->make();

        $this->postJson(route('cart.item.store'), [
            'cart_id' => $cart->id,
            'product_id' => 1,
            'qty' => 1
        ])->assertUnauthorized();
    }

    public function test_cart_item_qty_updated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()
                ->for(Category::factory()->create())
                ->create();


        $cart = Cart::factory()->create();

        $this->putJson(route('cart.item.update', $cart->id), [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 2
        ])->assertCreated();
    }
}
