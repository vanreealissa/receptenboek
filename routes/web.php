<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/recepten');

Route::resource('recepten', RecipeController::class)
    ->names('recipes')
    ->parameters(['recepten' => 'recipe']);
