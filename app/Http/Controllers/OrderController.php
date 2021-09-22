<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Crypt;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(\App\Models\Order $order)
    {
        $orderId = $order->id;
        $product = DB::table('order__products')->join('orders', 'order_id', '=' , 'orders.id')->join('products', 'product_id', '=' , 'products.id')->select('products.name', 'order__products.amount')->where('orders.id', '=', $orderId)->get();
        return view ('order', compact('order', 'orderId', 'product'));
    }
}
