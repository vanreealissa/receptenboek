@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
    <p><a href="{{ route('recipes.index') }}">← Alle recepten</a></p>

    <div class="row between" style="margin-bottom:8px;align-items:flex-start">
        <div>
            <span class="badge">{{ $recipe->category->label() }}</span>
            <h1 style="margin-top:8px">{{ $recipe->title }}</h1>
        </div>
        <div class="row">
            <a class="btn secondary small" href="{{ route('recipes.edit', $recipe) }}">Bewerken</a>
            <form method="POST" action="{{ route('recipes.destroy', $recipe) }}" onsubmit="return confirm('Dit recept verwijderen?')">
                @csrf
                @method('DELETE')
                <button class="btn danger small" type="submit">Verwijderen</button>
            </form>
        </div>
    </div>
    @if ($recipe->description)
        <p class="lead">{{ $recipe->description }}</p>
    @endif
    <p class="muted">⏱ {{ $recipe->prep_minutes }} minuten</p>

    <div class="recipe-layout">
        <section class="card">
            <h2>Ingrediënten</h2>
            <div class="row" style="margin-bottom:12px" aria-label="Aantal porties">
                <a class="btn secondary small" href="{{ route('recipes.show', [$recipe, 'porties' => max(1, $servings - 1)]) }}" aria-label="Minder porties">−</a>
                <strong class="num">{{ $servings }} {{ $servings === 1 ? 'portie' : 'porties' }}</strong>
                <a class="btn secondary small" href="{{ route('recipes.show', [$recipe, 'porties' => min(24, $servings + 1)]) }}" aria-label="Meer porties">+</a>
            </div>
            @if ($servings !== $recipe->servings)
                <p class="hint">Omgerekend van {{ $recipe->servings }} porties. <a href="{{ route('recipes.show', $recipe) }}">Herstel</a></p>
            @endif
            <ul class="ingredients">
                @foreach ($ingredients as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </section>

        <section class="card">
            <h2>Bereiding</h2>
            <ol class="steps">
                @foreach ($recipe->stepList() as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        </section>
    </div>
@endsection
