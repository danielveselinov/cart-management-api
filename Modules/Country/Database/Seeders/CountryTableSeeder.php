<?php

namespace Modules\Country\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Country\Entities\Country;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=0; $i < 10; $i++) { 
            Country::create(['name' => fake()->country(), 'key' => fake()->countryCode()]);
        }
    }
}
