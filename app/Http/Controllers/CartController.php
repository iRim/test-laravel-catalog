<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\BuyRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Cart/Index', [
            'products' => Product::query()->get()
        ]);
    }

    public function buy(BuyRequest $request): RedirectResponse
    {
        $order = Order::query()
            ->create([
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'total_amount' => 0
            ]);

        $order
            ->products()
            ->sync(
                collect($request->products)
                    ->mapWithKeys(fn ($p) => [
                        $p['id'] => ['quantity' => $p['quantity']]
                    ])
                    ->all()
            );

        $order->update([
            'total_amount' => $order
                ->products
                ->sum(fn($p) => $p->pivot->quantity * $p->price)
        ]);

        return redirect()->route('orders.index');
    }
}
