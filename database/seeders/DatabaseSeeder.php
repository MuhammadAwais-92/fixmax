<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker =  \Faker\Factory::create();
        $this->call([
            CitySeeder::class,
            PageSeeder::class,
        ]);
        $image = $faker->image(env("PUBLIC_PATH").'/uploads/admin',555,372,null,false);
        $imagePath = 'uploads/admin/'.$image;
        DB::table('admins')->insert([
            [
                'name' => "Super Admin",
                'email' => "admin@fix-max.com",
                'password' => bcrypt("123456"),
                'image' => $imagePath,
                'is_active' => 1,
                'is_verified' => 1,
                'created_at' => now()->unix(),
                'updated_at' => now()->unix(),
            ],

        ]);

    }
}
