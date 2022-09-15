<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Category\Entities\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    // use RefreshDatabase;
    // category.index - category.store - category.show - category.update - category.destory

    public function test_get_categories()
    {
        // Category::create(['name' => 'category']);

        $response = $this->getJson(route('category.index'));

        $this->assertEquals(1, count($response->json()));
    }

    // public function test_delete_category()
    // {
    //     $category = Category::factory()->create(['name' => 'category']);

    //     $this->deleteJson(route('category.destroy', $category->id))
    //             ->assertNoContent();
        
    //     $this->assertDatabaseMissing('categories', [
    //         'name' => $category->name
    //     ]);
    // }
}
