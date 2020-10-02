<?php

use Illuminate\Support\Facades\Route;
use OpenapiGenerator\Tests\App\Http\Controllers\AboutController;
use OpenapiGenerator\Tests\App\Http\Controllers\PetController;

/** Should be ignored because are closures */
Route::get('/', fn () => 'Hello world!');
Route::get('/contact', fn () => 'Please contact me');

/** Should be included because they pass the wild card. */
Route::group(['prefix' => 'api'], function () {
    Route::apiResource('pets', PetController::class);
});

/** Should not be included because they do not pass the wild card. */
Route::get('/about', [AboutController::class, 'index']);
