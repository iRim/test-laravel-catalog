<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdateRequest;

class ProductsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Products/Index', [
            'products' => Product::query()->get()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Product::query()
            ->create(
                $request->only([
                    'name',
                    'description',
                    'price',
                    'stock_quantity'
                ])
            );

        return redirect()->route('products.index');
    }


    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(UpdateRequest $request, Product $product): RedirectResponse
    {
        $product->update(
            $request->only([
                'name',
                'description',
                'price',
                'stock_quantity'
            ])
        );

        return redirect()->route('products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
