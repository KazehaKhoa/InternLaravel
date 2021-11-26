<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'product_name' => $this->faker->name(),
            'shop_id' => 1,
            'product_image' => $this->faker->imageUrl($width = 640, $height = 480),
            'product_price' => $this->faker->randomFloat(2,  0, 100000), // password
            'is_sales' => $this->faker->boolean,
            'description' => $this->faker->text,
        ];
    }
}
