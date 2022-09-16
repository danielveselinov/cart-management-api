<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Category\Entities\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    // category.index - category.store - category.show - category.update - category.destory

    public function test_get_categories()
    {
        $response = $this->getJson(route('category.index'));
        $response->assertJson([]);

        $response->assertStatus(202);
    }

    public function test_store_a_category()
    {
        $response = $this->postJson(route("category.store"), [
            'name' => 'category_test'
        ]);
        $response->assertJson([]);

        $response->assertStatus(202);
    }

    public function test_show_a_category()
    {
        $category = Category::where('name', '=', 'category_test')->first();
        $reesponse = $this->getJson(route('category.show', $category->id));
        $reesponse->assertDontSee([]);

        $reesponse->assertStatus(202);
    }

    public function test_update_a_category()
    {
        $category = Category::where('name', '=', 'category_test')->first();
        $response = $this->putJson(route('category.update', $category->id), [
            'name' => 'category_updated'
        ]);
        $response->assertDontSee([]);

        $response->assertStatus(202);
    }

    public function test_destory_a_category()
    {
        $category = Category::where('name', '=', 'category_updated')->first();
        $response = $this->deleteJson(route('category.destroy', $category->id));
        $response->assertNoContent();

        $response->assertStatus(204);
    }
}
