@extends('layouts.app')

@section('content')
<div class="container">
    OrderId: {{  $orderId }}
    Customer: {{ $order->user->name }}
    Sum: {{  $order->sum }}
    @foreach ($product as $product)
        {{  $product->name}}
        {{ $product->amount }}
    @endforeach
</div>
@endsection