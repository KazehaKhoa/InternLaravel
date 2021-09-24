<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Auth;
use Redirect;
use DB;

class OrderManagementController extends Controller
{
    public function index(\App\Models\User $user)
    {  
        if(auth()->user() == $user || auth()->user()->isAdmin == 1) {
            // valid user
            $order = \App\Models\User::findOrFail($user->id)->orders;
            return view ('orderManagement', compact('order','user'));
       } else {
            //not allowed
            return Redirect::to('orderM/' .auth()->user()->id);
       }
    }

    public function indexAdmin()
    {
        $order = \App\Models\Order::all();
        return view ('adminView', compact('order')); 
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
        $newOrderId = 1 + DB::table('orders')->count();
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

        return Redirect::to('admin/order/index');
    }
}
