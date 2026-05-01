<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('item_category')->truncate();
        DB::table('items')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                'name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolax',
                'description' => 'スタイリッシュなデザインのメンズ腕時計',
                'img_url' => 'image/watch.jpg',
                'condition_id' => 1, // 良好
                'categories' => [1, 5, 12] // ファッション, メンズ, アクセサリー
            ],
            [
                'name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'description' => '高速で信頼性の高いハードディスク',
                'img_url' => 'image/hdd.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'categories' => [2, 10] // 家電, PC
            ],
            [
                'name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'description' => '新鮮な玉ねぎ3束のセット',
                'img_url' => 'image/onion.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'categories' => [10] // キッチン（または食品）
            ],
            [
                'name' => '革靴',
                'price' => 4000,
                'brand' => '',
                'description' => 'クラシックなデザインの革靴',
                'img_url' => 'image/shoes.jpg',
                'condition_id' => 4, // 状態が悪い
                'categories' => [1, 5] // ファッション, メンズ
            ],
            [
                'name' => 'ノートPC',
                'price' => 45000,
                'brand' => '',
                'description' => '高性能なノートパソコン',
                'img_url' => 'image/laptop.jpg',
                'condition_id' => 1, // 良好
                'categories' => [2, 10] // 家電, PC
            ],
            [
                'name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'description' => '高音質のレコーディング用マイク',
                'img_url' => 'image/mic.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'categories' => [2] // 家電
            ],
            [
                'name' => 'ショルダーバッグ',
                'price' => 3500,
                'brand' => '',
                'description' => 'おしゃれなショルダーバッグ',
                'img_url' => 'image/bag.jpg',
                'condition_id' => 3, // やや傷や汚れあり
                'categories' => [1, 4] // ファッション, レディース
            ],
            [
                'name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'description' => '使いやすいタンブラー',
                'img_url' => 'image/tumbler.jpg',
                'condition_id' => 4, // 状態が悪い
                'categories' => [10] // キッチン
            ],
            [
                'name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'description' => '手動のコーヒーミル',
                'img_url' => 'image/coffee.jpg',
                'condition_id' => 1, // 良好
                'categories' => [10] // キッチン
            ],
            [
                'name' => 'メイクセット',
                'price' => 2500,
                'brand' => '',
                'description' => '便利なメイクアップセット',
                'img_url' => 'image/makeup.jpg',
                'condition_id' => 2, // 目立った傷や汚れなし
                'categories' => [4, 6] // レディース, コスメ
            ],
        ];

        foreach ($items as $itemData) {
            $categories = $itemData['categories'];
            unset($itemData['categories']); // itemテーブルに入れないデータを外す

            // データの整形
            $itemData['image_file'] = $itemData['img_url']; // カラム名に合わせる
            unset($itemData['img_url']);
            $itemData['user_id'] = 1; // 暫定でID:1のユーザー
            $itemData['created_at'] = now();
            $itemData['updated_at'] = now();

            $itemId = DB::table('items')->insertGetId($itemData);

            // 中間テーブルへの紐付け
            foreach ($categories as $categoryId) {
                DB::table('item_category')->insert([
                    'item_id' => $itemId,
                    'category_id' => $categoryId,
                ]);
            }
        }
    }
}
