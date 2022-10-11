<?php

namespace Modules\City\Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\City\Entities\City;
use Modules\Country\Entities\Country;

class CityTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_list_of_all_cities()
    {
        Sanctum::actingAs(User::factory()->create());
        
        $this
            ->getJson(route('city.index'))
            ->assertOk();
    }

    public function test_add_new_city()
    {
        Sanctum::actingAs(User::factory()->create());
        $country = Country::factory()->create();
        $city = City::factory()->create();

        $this
            ->postJson(route('city.store'), [
                'name' => $city->name,
                'country_id' => $country->id
            ])->assertCreated();
    }

    public function test_destroy_a_city()
    {
        Sanctum::actingAs(User::factory()->create());

        $country = Country::factory()->create();
        $city = City::factory()->create();

        $this
            ->deleteJson(route('city.destroy', [$city->id]))
            ->assertNoContent();
    }
}
