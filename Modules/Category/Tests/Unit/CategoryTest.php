<?php

namespace Modules\Category\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Category\Entities\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_destory_a_category()
    {
        $category = Category::factory()->create();
        $this->deleteJson(route('category.destroy', $category->id))
            ->assertNoContent();
    }

    public function test_force_delete_category_delete()
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
