<?php

namespace Modules\Category\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Category\Entities\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_categories()
    {
        $this->getJson(route('category.index'))
            ->assertStatus(202);
    }

    public function test_store_a_category()
    {
        $category = Category::factory()->create();

        $response = $this->postJson(route("category.store"), [
            'name' => $category->name
        ]);
        $this->assertDatabaseHas('categories', $response->json());
        $response->assertStatus(202);
    }

    public function test_show_a_category()
    {
        $category = Category::factory()->create();
        $this
            ->getJson(route('category.show', $category->id))
            ->assertStatus(202);
    }

    public function test_update_a_category()
    {
        $category = Category::factory()->create();

        $this
            ->putJson(route('category.update', $category->id), [
            'name' => 'category_updated'
            ])->assertStatus(202);
    }

    public function test_destory_a_category()
    {
        $category = Category::factory()->create();
        $this->deleteJson(route('category.destroy', $category->id))
            ->assertNoContent();
    }

    public function test_force_delete_category()
    {
        $category = Category::factory()->create();
        $this->deleteJson(route('category.delete', $category->id))
            ->assertNoContent();
    }

    public function test_restore_a_soft_deleted_category()
    {
        $category = Category::factory()->create(['deleted_at' => now()]);
        
        $this
            ->postJson(route('category.restore', $category->id))
            ->assertOk();
    }
}
