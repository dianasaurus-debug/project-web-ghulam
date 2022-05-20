<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $all_orders = Order::with('products')
            ->with('user')
            ->orderBy('created_at')
            ->paginate(10)
            ->withQueryString();
        return Inertia::render('Orders/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search', 'total'),
            'orders' => $all_orders
        ]);
    }
}
