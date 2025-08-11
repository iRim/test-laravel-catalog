<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Requests\Orders\UpdateRequest;

class OrdersController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Orders/Index', [
            'orders' => Order::query()->get()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Orders/Create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        Order::query()
            ->create(
                $request->only([
                    'customer_name',
                    'customer_email',
                    'total_amount',
                ])
            );

        return redirect()->route('orders.index');
    }


    public function edit(Order $order): Response
    {
        return Inertia::render('Orders/Edit', [
            'order' => $order
        ]);
    }

    public function update(UpdateRequest $request, Order $order): RedirectResponse
    {
        $order->update(
            $request->only([
                'customer_name',
                'customer_email',
                'total_amount',
            ])
        );

        return redirect()->route('orders.index');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();
        return redirect()->route('orders.index');
    }
}
