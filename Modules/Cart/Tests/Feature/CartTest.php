<?php

namespace Modules\Cart\Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Address\Entities\Address;
use Modules\Cart\Entities\Cart;
use Modules\Cart\Entities\CartItems;
use Modules\Cart\Entities\Order;
use Modules\Cart\Entities\OrderItems;
use Modules\Category\Entities\Category;
use Modules\PaymentType\Entities\PaymentType;
use Modules\Product\Entities\Product;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_cart_and_add_cart_items()
    {
        Sanctum::actingAs(User::factory()->create(['id' => 1]));
        $address = Address::factory()->create(['id' => 1, 'is_main' => 1]);
        
        $cart = Cart::factory()->create(['user_id' => 1, 'address_id' => $address->id]);
        
        $this->postJson(route('cart.item.store'), [
            'cart_id' => $cart->id,
            'product_id' => 1,
            'qty' => 1,
            'payment_type_id' => 1
        ])->assertCreated();
    }

    public function test_unauthenticated_user_try_to_add_cart_items_to_a_cart_throws_an_error()
    {
        $product = Product::factory()
                ->for(Category::factory()->create())
                ->create();

        $cart = Cart::factory()->create(['address_id' => 1, 'payment_type_id' => 1]);

        $this->postJson(route('cart.item.store'), [
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1
        ])->assertUnauthorized();
    }
    
    public function test_cart_item_qty_updated()
    {
        Sanctum::actingAs(User::factory()->create());

        $product = Product::factory()
                ->for(Category::factory()->create())
                ->create(['id' => 1]);

        Cart::factory()->create(['id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);
        $item = CartItems::factory()->create(['cart_id' => 1, 'product_id' => 1]);
        
        $response = $this->putJson(route('cart.item.update', $item->cart->id), [
                'product_id' => $product->id,
                'cart_id' => $item->cart->id,
                'qty' => 2
        ])->assertOk();
        
        $this->assertDatabaseHas('cart_items', $response->json());
    }

    public function test_user_try_to_remove_cart_item()
    {
        Sanctum::actingAs(User::factory()->create());

        // Cart::factory()->create(['id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);
        $cartItem = CartItems::factory()->create();

        $this->deleteJson(route('cart.item.destroy', $cartItem->id))->assertNoContent();
    }

    public function test_user_can_checkout()
    {
        Sanctum::actingAs(User::factory()->create(['id' => 1]));

        $product = Product::factory()
                ->for(Category::factory()->create())
                ->create(['id' => 1]);

        $cart = Cart::factory()->create(['id' => 1, 'user_id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);
        CartItems::factory()->create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'qty' => 1
        ]);

        Order::factory()->create(['id' => 1, 'user_id' => 1, 'address_id' => 1, 'payment_type_id' => 1]);

        $this->postJson(route('cart.checkout', 1), [1])->assertOk();
    }

}
