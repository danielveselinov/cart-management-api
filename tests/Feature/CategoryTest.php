<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Modules\Category\Entities\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_categories()
    {
        $this->getJson(route('category.index'))
            ->assertJson([])
            ->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_store_a_category()
    {
        $category = Category::factory()->create();

        $this->postJson(route("category.store"), ['name' => $category->name])
            ->assertJson(['name' => $category->name])
            ->assertStatus(Response::HTTP_ACCEPTED);
    }

    // public function test_store_a_category_without_name()
    // {
    //     $this->postJson(route("category.store"), [
    //         'name' => null
    //     ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
    //     ->assertJson([]);
    // }

    public function test_show_a_category()
    {
        $category = Category::factory()->create();

        $this->getJson(route('category.show', $category->id))
            ->assertStatus(Response::HTTP_ACCEPTED)
            ->assertJson(['name' => $category->name]);
    }

    public function test_update_a_category()
    {
        $category = Category::factory()->create();

        $this->putJson(route('category.update', $category->id), [
            'name' => 'category_updated',
        ])->assertStatus(Response::HTTP_ACCEPTED);

        $this->getJson(route('category.show', $category->id))
            ->assertJson(['name' => 'category_updated']);
    }

    public function test_destory_a_category()
    {
        $category = Category::factory()->create();

        $this->deleteJson(route('category.destroy', $category->id))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
