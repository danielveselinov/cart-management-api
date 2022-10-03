<?php

namespace Modules\Product\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Product\Entities\Product;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_destory_a_product()
    {
        $product = Product::factory()->create();
        $this->deleteJson(route('product.destroy', $product->id))
            ->assertNoContent();
    }

    public function test_force_delete_product()
    {
        $product = Product::factory()->create();
        $this->deleteJson(route('product.delete', $product->id))
            ->assertNoContent();
    }

    public function test_restore_a_soft_deleted_product()
    {
        $product = Product::factory()->create(['deleted_at' => now()]);
        
        $this
            ->postJson(route('product.restore', $product->id))
            ->assertOk();
    }
}
