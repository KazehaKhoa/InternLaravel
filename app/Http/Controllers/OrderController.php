<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Redirect;

class OrderController extends Controller
{

    public function index(\App\Models\Order $order)
    {
        if(auth()->user() == $order->user || auth()->user()->isAdmin == 1) {
            // valid user
            $user = $order->user;
            $orderId = $order->id;
            $product = DB::table('order__products')->join('orders', 'order_id', '=' , 'orders.id')->join('products', 'product_id', '=' , 'products.id')->select('*')->where('orders.id', '=', $orderId)->get();
            return view ('order', compact('order', 'orderId', 'product', 'user'));
        } else {
            //not allowed
            return Redirect::to('orderM/' .auth()->user()->id);
       }
    }

    public function add()
    {
        $product = \App\Models\Product::all();
        return view ('addOrderForm', compact('product'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'userId' => 'required|exists:users,id',
        ]);
        
        
        $amount = $request->get('quantity');
        $numOfProducts = DB::table('products')->count();
        $lastOrder = DB::table('orders')->latest('id')->first();
        $newOrderId = 1 + $lastOrder->id;
        $sum = 0;

        for($i = 0; $i < $numOfProducts; $i++) {
            if($amount[$i] == null) {
                $amount[$i] = 0;
            }
            $product = DB::table('products')->select('*')->where('id', '=', $i + 1)->get();
            $sum = $sum + $amount[$i] * $product[0]->price;
        }
        //add to order
        \App\Models\Order::create([
            'user_id' => $data['userId'],
            'sum' => $sum,
            'state' => $request->get('orderState'),
            'order_date' => now(),
        ]);

        for($i = 0; $i < $numOfProducts; $i++) {
            if($amount[$i] == null) {
                $amount[$i] = 0;
            }
            $product = DB::table('products')->select('*')->where('id', '=', $i + 1)->get();

            $newStock = $product[0]->stock - $amount[$i];
            DB::table('products')
              ->where('id', '=', $i + 1)
              ->update(['stock' => $newStock]);
            if ($newStock == 0) {
                DB::table('products')
              ->where('id', '=', $i + 1)
              ->update(['state' => 'OUT OF STOCK']);
            }

            \App\Models\Order_Product::create([
                'order_id' => $newOrderId,
                'product_id' => $i + 1,
                'amount' => $amount[$i]
            ]);
        }
        return Redirect::to('admin/order');
    }

    public function edit(\App\Models\Order $order)
    {
        return view('editOrder', compact('order'));
    }

    public function update(\App\Models\Order $order, Request $request)
    {
        $newState = $request->get('orderState');
        DB::table('orders')->where('id', $order->id)->update(['state' => $newState ]);
        return Redirect::to('order/' .$order->id);
    }

    public function destroy(\App\Models\Order $order) {
        DB::table('orders')->where('id', $order->id)->delete();
        return Redirect::to('admin/order');
    }
}
