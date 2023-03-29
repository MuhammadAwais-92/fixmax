<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  \Faker\Factory::create();
        $arFaker = \Faker\Factory::create('ar_SA');

        for ($i=0; $i < 3; $i++) {
            $city = City::create([
                'name' => ['en'=>$faker->city(), 'ar'=>$arFaker->city()],
            ]);

        }
    }
}
