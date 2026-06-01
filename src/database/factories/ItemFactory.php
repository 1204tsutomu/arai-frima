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
            'user_id'     => User::factory(),
            'name'        => $this->faker->word(),
            'price'       => $this->faker->numberBetween(500, 10000),
            'description' => $this->faker->sentence(),

            'image_file'  => 'test_image.jpg',
        ];
    }
}
