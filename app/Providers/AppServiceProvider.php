<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale(config('app.locale'));

        // Nederlandse URL's: /recepten/nieuw en /recepten/{recept}/bewerken
        Route::resourceVerbs(['create' => 'nieuw', 'edit' => 'bewerken']);
    }
}
