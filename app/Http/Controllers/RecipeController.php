<?php

namespace App\Http\Controllers;

use App\Enums\Category;
use App\Http\Requests\RecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::tryFrom((string) $request->query('categorie'));

        $recipes = Recipe::query()
            ->search($request->query('zoek'))
            ->when($category, fn ($q) => $q->where('category', $category))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('recipes.index', [
            'recipes' => $recipes,
            'categories' => Category::cases(),
            'activeCategory' => $category,
            'search' => (string) $request->query('zoek'),
        ]);
    }

    public function create()
    {
        return view('recipes.form', ['recipe' => new Recipe(['servings' => 4, 'prep_minutes' => 30])]);
    }

    public function store(RecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());

        return redirect()->route('recipes.show', $recipe)->with('status', 'Recept toegevoegd.');
    }

    public function show(Request $request, Recipe $recipe)
    {
        $servings = max(1, min(24, (int) $request->query('porties', $recipe->servings)));

        return view('recipes.show', [
            'recipe' => $recipe,
            'servings' => $servings,
            'ingredients' => $recipe->ingredientList($servings / $recipe->servings),
        ]);
    }

    public function edit(Recipe $recipe)
    {
        return view('recipes.form', ['recipe' => $recipe]);
    }

    public function update(RecipeRequest $request, Recipe $recipe)
    {
        $recipe->update($request->validated());

        return redirect()->route('recipes.show', $recipe)->with('status', 'Wijzigingen opgeslagen.');
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return redirect()->route('recipes.index')->with('status', "“{$recipe->title}” is verwijderd.");
    }
}
