<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. まずは「土台」となるマスターデータを先に入れる
        $this->call([
            UserSeeder::class,       // ユーザー（これがないと user_id でエラーになる）
            CategorySeeder::class,   // カテゴリー
            ConditionSeeder::class,  // 商品の状態（これがないと今のエラーが出る）
        ]);

        // 2. 土台が揃ってから「商品」を入れる
        $this->call([
            ItemSeeder::class,
        ]);
    }
}
