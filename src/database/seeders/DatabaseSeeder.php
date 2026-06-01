<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ConditionSeeder::class,
        ]);


        $this->call([
            ItemSeeder::class,
        ]);
    }
}
