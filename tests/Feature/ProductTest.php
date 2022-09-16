<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
        
    public function test_get_products()
    {
        Product::factory()->for(Category::factory()->create())->create();

        $this->getJson(route('product.index'))
            ->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_store_a_product()
    {
        $product = Product::factory()->for(Category::factory()->create())->create();

        $this->postJson(route('product.store'), [
            'category_id' => $product->category->id,
            'name' => $product->name,
            'description' => $product->description,
            'old_price' => $product->old_price,
            'final_price' => $product->final_price
        ])->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_show_a_product()
    {
        $product = Product::factory()->for(Category::factory()->create())->create();
        
        $this->getJson(route('product.show', $product->id))
            ->assertJson(['name' => $product->name])
            ->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_update_a_product()
    {
        $product = Product::factory()->for(Category::factory()->create())->create();

        $this->putJson(route('product.update', $product->id), [
            'category_id' => $product->category->id,
            'name' => 'Product Updated',
            'description' => 'Product description updated',
            'old_price' => 1929,
            'final_price' => 999.82
        ])->assertStatus(Response::HTTP_ACCEPTED);

        $this->getJson(route('product.show', $product->id))
            ->assertJson(['name' => 'Product Updated']);
    }

    public function test_destory_a_product()
    {
        $product = Product::factory()->for(Category::factory()->create())->create();

        $this->deleteJson(route('product.destroy', $product->id))
            ->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertSee([]);
    }
}
