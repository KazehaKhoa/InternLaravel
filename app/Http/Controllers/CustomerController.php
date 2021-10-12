<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\CursorPaginator;
use Redirect;
use Validator;
use Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customers = DB::table('customers')->orderBy('id', 'desc')->paginate(20);
        return view('customer.index', compact('customers'));
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
            'tel_num' => 'required',
            'address' => 'required',
            'state' => 'required'
        ]);

        \App\Models\Customer::create([
            'customer_name' => $request->get('name'),
            'email' => $request->get('email'),
            'tel_num' => $request->get('tel_num'),
            'address' => $request->get('address'),
            'is_active' => $request->get('state'),
        ]);

        return Redirect('/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'telNum' => 'required',
            'address' => 'required'
        ]);

        DB::table('customers')->where('id', $customer->id)->update([
            'customer_name' => $request->get('name'),
            'email' => $request->get('email'),
            'tel_num' => $request->get('telNum'),
            'address' => $request->get('address'),
        ]);

        return Redirect('/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }

    public function search(Request $request) {

    }


}
