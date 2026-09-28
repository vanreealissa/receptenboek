@extends('layouts.app')

@section('title', $recipe->exists ? 'Bewerk '.$recipe->title : 'Nieuw recept')

@section('content')
    <h1>{{ $recipe->exists ? 'Recept bewerken' : 'Nieuw recept' }}</h1>
    <p class="lead">Zet elk ingrediënt en elke stap op een eigen regel. Begin ingrediënten met de hoeveelheid, dan kan het boek ze omrekenen.</p>

    <form method="POST" action="{{ $recipe->exists ? route('recipes.update', $recipe) : route('recipes.store') }}" class="card" style="max-width:720px">
        @csrf
        @if ($recipe->exists)
            @method('PUT')
        @endif

        <div class="field">
            <label for="title">Naam</label>
            <input id="title" name="title" type="text" value="{{ old('title', $recipe->title) }}" required @class(['is-invalid' => $errors->has('title')])>
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-row">
            <div class="field">
                <label for="category">Categorie</label>
                <select id="category" name="category" required @class(['is-invalid' => $errors->has('category')])>
                    <option value="">Kies…</option>
                    @foreach (\App\Enums\Category::cases() as $category)
                        <option value="{{ $category->value }}" @selected(old('category', $recipe->category?->value) === $category->value)>{{ $category->label() }}</option>
                    @endforeach
                </select>
                @error('category') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="prep_minutes">Bereidingstijd (min)</label>
                <input id="prep_minutes" name="prep_minutes" type="number" min="1" max="1440" value="{{ old('prep_minutes', $recipe->prep_minutes) }}" required @class(['is-invalid' => $errors->has('prep_minutes')])>
                @error('prep_minutes') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="field">
                <label for="servings">Porties</label>
                <input id="servings" name="servings" type="number" min="1" max="24" value="{{ old('servings', $recipe->servings) }}" required @class(['is-invalid' => $errors->has('servings')])>
                @error('servings') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="field">
            <label for="description">Korte omschrijving <span class="hint">(optioneel)</span></label>
            <textarea id="description" name="description" style="min-height:70px">{{ old('description', $recipe->description) }}</textarea>
            @error('description') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="ingredients">Ingrediënten</label>
            <textarea id="ingredients" name="ingredients" placeholder="250 g spaghetti&#10;2 teentjes knoflook&#10;½ el chilivlokken" required @class(['is-invalid' => $errors->has('ingredients')])>{{ old('ingredients', $recipe->ingredients) }}</textarea>
            <span class="hint">Eén ingrediënt per regel.</span>
            @error('ingredients') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="field">
            <label for="steps">Bereiding</label>
            <textarea id="steps" name="steps" style="min-height:180px" required @class(['is-invalid' => $errors->has('steps')])>{{ old('steps', $recipe->steps) }}</textarea>
            <span class="hint">Eén stap per regel. De stappen worden automatisch genummerd.</span>
            @error('steps') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <button class="btn" type="submit">{{ $recipe->exists ? 'Wijzigingen opslaan' : 'Recept toevoegen' }}</button>
            <a class="btn secondary" href="{{ $recipe->exists ? route('recipes.show', $recipe) : route('recipes.index') }}">Annuleren</a>
        </div>
    </form>
@endsection
