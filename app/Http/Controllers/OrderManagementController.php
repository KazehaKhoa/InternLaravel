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

    public function showAdmin()
    {
        $order = \App\Models\Order::all();
        return view ('adminView', compact('order')); 
    }
}
