<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => $this->faker->unique()->uuid(),
            'book_name' => $this->faker->sentence(3),
            'genre' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'main_img' => $this->faker->imageUrl(),
            'isbn' => $this->faker->isbn13(),
            'author_id' => Author::factory(),
        ];
    }
}