<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;

/**
 * @extends Factory<Book>
 */
#[UseModel(Book::class)]
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
            'title' => fake()->sentence(),
            'author' => fake()->name(),
            'description' => fake()->paragraph(),
            'published_year' => fake()->year(),
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
