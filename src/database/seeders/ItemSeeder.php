<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'name' => '腕時計',
                'price' => 15000,
                'image_name' => 'Armani+Mens+Clock.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '商品名',
                'price' => 2000,
                'image_name' => 'Armani+Mens+Clock.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '商品名',
                'price' => 3000,
                'image_name' => 'Armani+Mens+Clock.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
