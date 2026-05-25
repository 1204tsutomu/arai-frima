<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => User::factory(),          // 出品者（誰が出品したか）
            'name'        => $this->faker->word(),     // 商品名
            'price'       => $this->faker->numberBetween(500, 10000), // 価格
            'description' => $this->faker->sentence(), // 商品説明
            // ⚠️ もし教材のマイグレーション（テーブル定義）に「画像（image_urlなど）」や
            // 「状態（condition）」などの必須カラムがあれば、ここに追記してください。
            'image_file'  => 'test_image.jpg',
        ];
    }
}
