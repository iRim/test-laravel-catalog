<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index');
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }
}
