<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;
use Auth;

class OrderManagementController extends Controller
{
    public function index(\App\Models\User $user)
    {  
        if(Auth::user() == $user) {
            // valid user
            $user = Auth::user();
            $order = \App\Models\User::findOrFail($user->id)->orders;
            return view ('orderManagement', compact('order','user'));
       } else {
            //not allowed
            abort(403);
       }
       
    }
}
