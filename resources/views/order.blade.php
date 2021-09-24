@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center"><h3>OrderId: {{  $orderId }}</h3></div>
    <h4>Customer: {{ $order->user->name }}</h4>
    <table class="mt-5 table table-light">
        
        <thead class="thead-dark">
        <tr>
            <th>Product</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        </thead>
    @foreach ($product as $product)
        <tr>
            <td>{{  $product->name }}</td>
            <td>{{  $product->price }}</td>
            <td>{{  $product->amount }}</td>
        </tr>
    @endforeach
        <tr class="table-secondary">
            <td></td>
            <td>Sum:</td>
            <td>{{  $order->sum }}</td>
        </tr>
    
    </table>
    <textarea class="mt-5 pt-5 form-control text-center font-weight-bold" id="orderNote" rows="3">{{  $order->state }}</textarea>
    
</div>
@endsection