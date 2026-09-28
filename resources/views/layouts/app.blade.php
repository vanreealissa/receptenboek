<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Alle recepten') · Receptenboek</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a class="brand" href="{{ route('recipes.index') }}">Recepten<span>boek</span></a>
            <nav class="nav">
                <a href="{{ route('recipes.index') }}" @class(['active' => request()->routeIs('recipes.index')])>Alle recepten</a>
                <a href="{{ route('recipes.create') }}" @class(['active' => request()->routeIs('recipes.create')])>+ Nieuw recept</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('status'))
            <div class="alert success" role="status">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">Receptenboek · demo-project gebouwd met Laravel {{ app()->version() }}</div>
    </footer>
</body>
</html>
