<?php

namespace OpenapiGenerator\Tests\App\Http\Controllers;

use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return [type]           [description]
     */
    public function index(Request $request)
    {
        return 'Hello world!';
    }
}

