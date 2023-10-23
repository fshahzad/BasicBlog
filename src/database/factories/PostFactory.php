<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $text = fake()->text(rand(500,1000)) . PHP_EOL . PHP_EOL . fake()->text(rand(100,500)) . PHP_EOL .PHP_EOL . fake()->text(rand(500,1000));
        logger($text);
        return [
            'title' => fake()->sentence(),
            'body' => $text,
        ];
    }
}
