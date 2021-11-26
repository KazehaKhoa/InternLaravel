<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Models\Customer;
use Illuminate\Http\Request;
use DB;
use Illuminate\Pagination\CursorPaginator;
use Redirect;
use Validator;
use Hash;
use Excel;

class CustomerController extends Controller
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
            'name' => 'required|min:5',
            'email' => 'required|email|unique:customers,email',
            'tel_num' => 'required|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'address' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        \App\Models\Customer::create([
            'customer_name' => $request->get('name'),
            'email' => $request->get('email'),
            'tel_num' => $request->get('tel_num'),
            'address' => $request->get('address'),
            'is_active' => $request->get('state'),
        ]);

        return response()->json(['success'=>'Update record.']);
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
            'name' => 'required|min:5',
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'telNum' => 'required|regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/',
            'address' => 'required'
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
        }

        DB::table('customers')->where('id', $customer->id)->update([
            'customer_name' => $request->get('name'),
            'email' => $request->get('email'),
            'tel_num' => $request->get('telNum'),
            'address' => $request->get('address'),
        ]);

        return response()->json(['success'=>'Update record.']);
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

    public function search(Request $request)
    {
        $customers = DB::table('customers')->select('*')->where([
            ['customer_name', 'LIKE', '%'.$request->get('name').'%'],
            ['email', 'LIKE', '%'.$request->get('email').'%'],
            ['is_active',  'LIKE', '%'.$request->get('state').'%'],
            ['address',  'LIKE', '%'.$request->get('address').'%'],
            ])->paginate(20);
        if ($request->ajax()) {
            return view('customer.search', compact('customers'))->render();
        }
        return view('customer.index', compact('customers'));
    }

    public function exportToExcel() {
        return Excel::download(new CustomerExport, 'customers.xlsx');
    }

}
