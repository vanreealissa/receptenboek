<?php

namespace Database\Factories;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst(fake()->words(3, true)),
            'category' => fake()->randomElement(Category::cases()),
            'description' => fake()->sentence(),
            'prep_minutes' => fake()->numberBetween(10, 90),
            'servings' => 4,
            'ingredients' => "200 g bloem\n2 eieren\nsnufje zout",
            'steps' => "Meng alles.\nBak het af.",
        ];
    }
}
