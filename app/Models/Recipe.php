<?php

namespace App\Models;

use App\Enums\Category;
use App\Support\IngredientScaler;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category', 'description', 'prep_minutes', 'servings', 'ingredients', 'steps'];

    protected function casts(): array
    {
        return [
            'category' => Category::class,
            'prep_minutes' => 'integer',
            'servings' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Recipe $recipe) {
            if (! $recipe->slug || $recipe->isDirty('title')) {
                $recipe->slug = static::uniqueSlug($recipe->title, $recipe->id);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'recept';
        $slug = $base;

        for ($i = 2; static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))->exists(); $i++) {
            $slug = "{$base}-{$i}";
        }

        return $slug;
    }

    public function scopeSearch(Builder $query, ?string $term): void
    {
        $term = trim((string) $term);

        if ($term !== '') {
            $query->where(fn (Builder $q) => $q
                ->where('title', 'like', "%{$term}%")
                ->orWhere('ingredients', 'like', "%{$term}%"));
        }
    }

    /** @return list<string> */
    public function ingredientList(float $factor = 1.0): array
    {
        $scaler = app(IngredientScaler::class);

        return array_map(fn (string $line) => $scaler->scale($line, $factor), $this->lines($this->ingredients));
    }

    /** @return list<string> */
    public function stepList(): array
    {
        return $this->lines($this->steps);
    }

    /** @return list<string> */
    private function lines(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\R/', (string) $text))));
    }
}
