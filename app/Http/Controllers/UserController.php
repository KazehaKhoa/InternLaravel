<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\CursorPaginator;
use Redirect;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        $users = DB::table('users')->orderBy('id', 'desc')->paginate(20);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'group' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        \App\Models\User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'group' => $request->get('group'),
            'state' => $request->get('state'),
        ]);

        return response()->json(['success'=>'Update record.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => '',
            'confirmation' => 'same:password',
            'group' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        if($request->filled('password')) {
            DB::table('users')->where('id', $user->id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
                'group' => $request->get('group'),
                'state' => $request->get('state'),
            ]);
        } else {
            DB::table('users')->where('id', $user->id)->update([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'group' => $request->get('group'),
                'state' => $request->get('state'),
            ]);
        }
        return response()->json(['success'=>'Update record.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->get('id');
        DB::table('users')->where('id', $id)->delete();
        return Redirect::to('/user');
    }


    public function search(Request $request)
    {
        $users = DB::table('users')->select('*')->where([
            ['name', 'LIKE', '%'.$request->get('name').'%'],
            ['email', 'LIKE', '%'.$request->get('email').'%'],
            ['group',  'LIKE', '%'.$request->get('group').'%'],
            ['state',  'LIKE', '%'.$request->get('state').'%'],
            ])->paginate(20);
        if ($request->ajax()) {
            return view('user.search', compact('users'))->render();
        }
        return view('user.index', compact('users'));
    }

    public function lock(Request $request)
    {
        //
        $id = $request->get('id');
        $data = DB::table('users')->select('*')->where('id', $id)->get();
        $user = $data[0];
        if($user->state == 1) {
            $user->state = 0;
        }
        else {
            $user->state =1;
        }

        DB::table('users')->where('id', $user->id)->update([
            'state' => $user->state,
        ]);

        $email = DB::table('users')->select('email')->where('id', $id)->get();
        if($request->ajax()) {
            return $email[0];
        }
    }
}
