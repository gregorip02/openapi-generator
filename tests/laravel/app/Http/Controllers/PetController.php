<?php

namespace OpenapiGenerator\Tests\App\Http\Controllers;

use Illuminate\Http\Request;
use OpenapiGenerator\Tests\App\Http\Resources\PetResourceCollection;
use OpenapiGenerator\Tests\App\Models\Pet;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \OpenapiGenerator\Tests\App\Http\Resources\PetResourceCollection
     */
    public function index(Request $request): PetResourceCollection
    {
        $pets = Pet::all();

        return PetResourceCollection::make($pets);
    }
}

