<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;
use Redirect;
use Validator;
use Storage;

class ProductController extends Controller
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
        $products = DB::table('products')->orderBy('id', 'desc')->paginate(20);
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view ('product.add');
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
        $request->validate([
            'file' => 'image|max:2048|mimes:jpeg,png,jpg|dimensions:max_height=1024,max_width=1024',
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:0',
            'state' => 'required',
        ]);

        $path = $request->file('file')->store('images', 'public');
        $url = Storage::url($path);

        \App\Models\Product::create([
            'product_name' => $request->get('name'),
            'shop_id' => 1,
            'product_image' => $url,
            'product_price' => $request->get('price'),
            'is_sales' => $request->get('state'),
            'description' => $request->get('description')
        ]);

        return Redirect('/product');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        return view ('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $request->validate([
            'file' => 'image|max:2048|mimes:jpeg,png,jpg|dimensions:max_height=1024,max_width=1024',
            'name' => 'required|min:5',
            'price' => 'required|numeric|min:0',
            'state' => 'required',
        ]);

        if($request->hasFile('file')) {
            $path = $request->file('file')->store('images', 'public');
            $url = Storage::url($path);

            DB::table('products')->where('id', $product->id)->update([
                'product_name' => $request->get('name'),
                'shop_id' => 1,
                'product_image' => $url,
                'product_price' => $request->get('price'),
                'is_sales' => $request->get('state'),
                'description' => $request->get('description')
            ]);
        } else {
            DB::table('products')->where('id', $product->id)->update([
                'product_name' => $request->get('name'),
                'product_price' => $request->get('price'),
                'is_sales' => $request->get('state'),
                'description' => $request->get('description')
            ]);
        }
        

        return Redirect('/product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        //
        $id = $request->get('id');
        DB::table('products')->where('id', $id)->delete();
        return Redirect::to('/product');
    }

    public function search(Request $request)
    {
        if($request->get('fromPrice') == null && $request->get('toPrice') == null) {
            $products = DB::table('products')->select('*')->where([
                ['product_name', 'LIKE', '%'.$request->get('name').'%'],
                ['is_sales',  'LIKE', '%'.$request->get('state').'%'],
            ])->paginate(20);
        }
        else if($request->get('fromPrice') != null && $request->get('toPrice') == null) {
            $products = DB::table('products')->select('*')->where([
                ['product_name', 'LIKE', '%'.$request->get('name').'%'],
                ['is_sales',  'LIKE', '%'.$request->get('state').'%'],
                ['product_price', '>=', $request->get('fromPrice')],
            ])->paginate(20);
        }
        else if($request->get('fromPrice') == null && $request->get('toPrice') != null) {
            $products = DB::table('products')->select('*')->where([
                ['product_name', 'LIKE', '%'.$request->get('name').'%'],
                ['is_sales',  'LIKE', '%'.$request->get('state').'%'],
                ['product_price', '<=', $request->get('toPrice')],
            ])->paginate(20);
        }
        else if($request->get('fromPrice') != null && $request->get('toPrice') != null) {
            $products = DB::table('products')->select('*')->where([
                ['product_name', 'LIKE', '%'.$request->get('name').'%'],
                ['is_sales',  'LIKE', '%'.$request->get('state').'%'],
                ['product_price', '>=', $request->get('fromPrice')],
                ['product_price', '<=', $request->get('toPrice')],
            ])->paginate(20);
        }
        if ($request->ajax()) {
            return view('product.search', compact('products'))->render();
        }
        return view('product.index', compact('products'));
    }
}
