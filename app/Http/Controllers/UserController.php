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
            'password' => 'required|confirmed',
            'group' => 'required'
        ]);

        \App\Models\User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'group' => $request->get('group'),
            'state' => $request->get('state'),
        ]);

        return Redirect('/user');
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
            'password' => 'required|confirmed',
            'group' => 'required'
        ]);

        DB::table('users')->where('id', $user->id)->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'group' => $request->get('group'),
            'state' => $request->get('state'),
        ]);

        return Redirect('/user');
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
        return Redirect::to('user/');
    }


    public function search(Request $request)
    {
        $output = '';
        $results = DB::table('users')->select('*')->where([
            ['name', 'LIKE', '%'.$request->get('hoten').'%'],
            ['email', 'LIKE', '%'.$request->get('email').'%'],
            ['group', $request->get('group')],
            ['state', $request->get('state')],
        ])->paginate(20);
        foreach ($results as $result)
        {
            if($result->state == 1) {
                $output = '
                                <tr class="font-weight-bold">
                                <th scope="row">'.$result->id.'</th>
                                <td>'.$result->name.'</td>
                                <td>'.$result->email.'</td>
                                <td>'.$result->group.'</td>
                                <td class="text-success">Đang hoạt động</td>
                                </tr>';
            }
            else {
                $output = '
                                <tr class="font-weight-bold">
                                <th scope="row">'.$result->id.'</th>
                                <td>'.$result->name.'</td>
                                <td>'.$result->email.'</td>
                                <td>'.$result->group.'</td>
                                <td class="text-danger">Tạm khóa</td>
                                </tr>';
            }
            
        }
        if($request->ajax()){
            return response()->json($output);
        }
        return view('user.index', compact('results'));
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
        else if($user->state == 0) {
            $user->state =1;
        }

        DB::table('users')->where('id', $user->id)->update([
            'state' => $user->state,
        ]);

        return Redirect('/user');
    }
}
