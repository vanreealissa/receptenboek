<?php

namespace App\Http\Requests;

use App\Enums\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RecipeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'category' => ['required', Rule::enum(Category::class)],
            'description' => ['nullable', 'string', 'max:500'],
            'prep_minutes' => ['required', 'integer', 'between:1,1440'],
            'servings' => ['required', 'integer', 'between:1,24'],
            'ingredients' => ['required', 'string', 'max:5000'],
            'steps' => ['required', 'string', 'max:10000'],
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'naam',
            'category' => 'categorie',
            'description' => 'omschrijving',
            'prep_minutes' => 'bereidingstijd',
            'servings' => 'aantal porties',
            'ingredients' => 'ingrediënten',
            'steps' => 'bereiding',
        ];
    }
}
