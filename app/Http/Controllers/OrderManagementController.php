<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Gate;

class OrderManagementController extends Controller
{

    public function __construct()
    {
        $this->authorize('view');
    }

    public function index(\App\Models\User $user)
    {  
        
        $order = \App\Models\User::findOrFail($user->id)->orders;
        return view ('orderManagement', compact('order','user'));
    }
}
