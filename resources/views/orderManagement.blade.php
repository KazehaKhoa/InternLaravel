@extends('layouts.app')

@section('content')
<div class="container">
    <table class="mt-5 table table-light table-hover table-active">
        <thead class="thead-dark">
        <tr>
            <th>OrderIndex</th>
            <th>Customer</th>
            <th>Sum ($USD)</th>
            <th>Order Date</th>
        </tr>
        </thead>
    @foreach ($order as $order)
    <tr onclick="window.location='/order/{{ $order->id }}'">
        <td>{{  $order->id }}</td>
        <td>{{  $order->user->name }}</td>
        <td>{{  $order->sum }}</td>
        <td>{{  $order->order_date }}</td>
    </tr>
    @endforeach
    </table>
    
</div>
@endsection
