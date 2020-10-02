<?php

use Illuminate\Support\Facades\Route;
use OpenapiGenerator\Tests\App\Http\Controllers\PetController;

Route::get('/', fn () => 'It works!');
Route::apiResource('pets', PetController::class);
