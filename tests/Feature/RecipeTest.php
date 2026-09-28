<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $overrides = []): array
    {
        return [
            'title' => 'Pompoensoep',
            'category' => 'diner',
            'description' => 'Romige herfstsoep.',
            'prep_minutes' => 35,
            'servings' => 4,
            'ingredients' => "1 pompoen\n1 ui\n750 ml bouillon",
            'steps' => "Snijd de pompoen.\nKook alles gaar.\nPureer de soep.",
            ...$overrides,
        ];
    }

    public function test_home_redirects_to_recipe_list(): void
    {
        $this->get('/')->assertRedirect('/recepten');
    }

    public function test_recipes_can_be_searched_by_title_and_ingredient(): void
    {
        Recipe::factory()->create(['title' => 'Pasta pesto', 'ingredients' => '250 g pasta']);
        Recipe::factory()->create(['title' => 'Groentecurry', 'ingredients' => "1 courgette\n400 ml kokosmelk"]);

        $this->get('/recepten?zoek=pesto')->assertSee('Pasta pesto')->assertDontSee('Groentecurry');
        $this->get('/recepten?zoek=courgette')->assertSee('Groentecurry')->assertDontSee('Pasta pesto');
    }

    public function test_recipes_can_be_filtered_by_category(): void
    {
        Recipe::factory()->create(['title' => 'Croissant', 'category' => Category::Ontbijt]);
        Recipe::factory()->create(['title' => 'Stoofvlees', 'category' => Category::Diner]);

        $this->get('/recepten?categorie=ontbijt')->assertSee('Croissant')->assertDontSee('Stoofvlees');
    }

    public function test_a_recipe_can_be_created(): void
    {
        $this->get('/recepten/nieuw')->assertOk();

        $this->post('/recepten', $this->validData())->assertRedirect('/recepten/pompoensoep');

        $this->assertDatabaseHas('recipes', ['slug' => 'pompoensoep', 'category' => 'diner']);
    }

    public function test_duplicate_titles_get_unique_slugs(): void
    {
        $this->post('/recepten', $this->validData());
        $this->post('/recepten', $this->validData());

        $this->assertSame(['pompoensoep', 'pompoensoep-2'], Recipe::orderBy('id')->pluck('slug')->all());
    }

    public function test_validation_errors_are_shown(): void
    {
        $this->post('/recepten', $this->validData(['title' => '', 'category' => 'soep', 'servings' => 0]))
            ->assertSessionHasErrors(['title', 'category', 'servings']);

        $this->assertSame(0, Recipe::count());
    }

    public function test_a_recipe_can_be_updated(): void
    {
        $recipe = Recipe::factory()->create(['title' => 'Oude naam']);

        $this->get("/recepten/{$recipe->slug}/bewerken")->assertOk()->assertSee('Oude naam');

        $this->put("/recepten/{$recipe->slug}", $this->validData(['title' => 'Nieuwe naam']))
            ->assertRedirect('/recepten/nieuwe-naam');

        $this->assertSame('nieuwe-naam', $recipe->fresh()->slug);
    }

    public function test_a_recipe_can_be_deleted(): void
    {
        $recipe = Recipe::factory()->create();

        $this->delete("/recepten/{$recipe->slug}")->assertRedirect('/recepten');

        $this->assertModelMissing($recipe);
    }

    public function test_ingredients_are_scaled_to_the_chosen_servings(): void
    {
        $recipe = Recipe::factory()->create([
            'title' => 'Pannenkoeken',
            'servings' => 4,
            'ingredients' => "250 g bloem\n2 eieren\nsnufje zout",
        ]);

        $this->get("/recepten/{$recipe->slug}?porties=6")
            ->assertOk()
            ->assertSee('375 g bloem')
            ->assertSee('3 eieren')
            ->assertSee('snufje zout')
            ->assertSee('Omgerekend van 4 porties');
    }
}
