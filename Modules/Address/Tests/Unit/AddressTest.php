<?php

namespace Modules\Address\Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Address\Entities\Address;
use Modules\City\Entities\City;
use Modules\Country\Entities\Country;

class AddressTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_get_all_addresses()
    {
        Sanctum::actingAs(User::factory()->create());

        $this
            ->getJson(route('address.index'))
            ->assertOk();
    }

    public function test_store_new_address()
    {
        Sanctum::actingAs(User::factory()->create());
        
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $address = Address::factory()->create();

        $this
            ->postJson(route('address.store'), [
                'user_id' => 1,
                'country_id' => $country->id,
                'city_id' => $city->id,
                'area' => $address->area,
                'street' => $address->street,
                'building' => $address->building,
                'apartment' => $address->apartment,
                'landmark' => $address->landmark,
                'is_main' => $address->is_main
            ])->assertCreated();

    }

    public function test_update_address()
    {
        Sanctum::actingAs(User::factory()->create());
        
        $country = Country::factory()->create();
        $city = City::factory()->create();
        $address = Address::factory()->create();

        $this
            ->putJson(route('address.update', $address->id), [
                'country_id' => $country->id,
                'city_id' => $city->id,
                'area' => $address->area,
                'street' => $address->street,
                'building' => $address->building,
                'apartment' => $address->apartment,
                'landmark' => $address->landmark,
                'is_main' => $address->is_main
            ])->assertOk();        
    }

    public function test_delete_address()
    {
        Sanctum::actingAs(User::factory()->create());

        $address = Address::factory()->create();

        $this
            ->deleteJson(route('address.destroy', $address->id))
            ->assertNoContent();
    }
}
