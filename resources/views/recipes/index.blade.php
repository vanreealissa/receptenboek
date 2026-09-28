@extends('layouts.app')

@section('content')
    <div class="row between" style="margin-bottom:8px">
        <h1>Recepten</h1>
        <a class="btn" href="{{ route('recipes.create') }}">+ Nieuw recept</a>
    </div>
    <p class="lead">Zoek op gerecht of ingrediënt, of filter op categorie.</p>

    <form method="GET" action="{{ route('recipes.index') }}" class="row" style="margin-bottom:16px" role="search">
        <input type="search" name="zoek" value="{{ $search }}" placeholder="Bijvoorbeeld: pasta of courgette" aria-label="Zoek recepten" style="flex:1;min-width:200px">
        @if ($activeCategory)
            <input type="hidden" name="categorie" value="{{ $activeCategory->value }}">
        @endif
        <button class="btn" type="submit">Zoeken</button>
    </form>

    <div class="row" style="margin-bottom:28px">
        <a href="{{ route('recipes.index', array_filter(['zoek' => $search])) }}" class="btn small {{ $activeCategory ? 'secondary' : '' }}">Alles</a>
        @foreach ($categories as $category)
            <a href="{{ route('recipes.index', array_filter(['zoek' => $search, 'categorie' => $category->value])) }}"
               class="btn small {{ $activeCategory === $category ? '' : 'secondary' }}">{{ $category->label() }}</a>
        @endforeach
    </div>

    @if ($recipes->isEmpty())
        <div class="card">
            <p style="margin:0">Geen recepten gevonden{{ $search ? " voor “{$search}”" : '' }}.
                <a href="{{ route('recipes.create') }}">Voeg een recept toe</a>.</p>
        </div>
    @else
        <div class="grid">
            @foreach ($recipes as $recipe)
                <article class="card stack recipe-card">
                    <span class="badge" style="justify-self:start">{{ $recipe->category->label() }}</span>
                    <h2 style="margin:0"><a href="{{ route('recipes.show', $recipe) }}">{{ $recipe->title }}</a></h2>
                    <p class="muted" style="margin:0">{{ \Illuminate\Support\Str::limit($recipe->description, 110) }}</p>
                    <p class="hint" style="margin:0">⏱ {{ $recipe->prep_minutes }} min · {{ $recipe->servings }} porties</p>
                </article>
            @endforeach
        </div>

        {{ $recipes->links('partials.pagination') }}
    @endif
@endsection
