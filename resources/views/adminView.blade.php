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
            <th></
        </tr>
        </thead>
    @foreach ($order as $order)
    <tr>
        <td  onclick="window.location='/order/{{ $order->id }}'">{{  $order->id }}</td>
        <td  onclick="window.location='/order/{{ $order->id }}'">{{  $order->user->name }}</td>
        <td  onclick="window.location='/order/{{ $order->id }}'">{{  $order->sum }}</td>
        <td  onclick="window.location='/order/{{ $order->id }}'">{{  $order->order_date }}</td>
        <td><a class="btn" href="/order/1"><i class="fa fa-trash"></i></a></td>
    </tr>
    @endforeach
    </table>

    <a class="btn" href="/admin/order/add"><i class="fa fa-plus"></i></button>
    
</div>
@endsection
