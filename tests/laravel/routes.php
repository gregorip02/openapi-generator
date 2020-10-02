<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => 'It works!');
Route::apiResource('pets', 'PetController');
