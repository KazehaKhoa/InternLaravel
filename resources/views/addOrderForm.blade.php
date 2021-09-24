@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/admin/order" enctype="multipart/form-data" method="POST">
        @csrf
        
        <label for="userId">User ID:</label><br>
        <input type="text" id="userId" name="userId"><br>
        @if ($errors->has('userId'))
            <strong style="color:red">{{ $errors->first('userId') }}</strong>
        @endif

        <label for="orderState">Order Description:</label><br>
        <input type="text" id="orderState" name="orderState"><br>

        @foreach ($product as $product)
            {{  $product->name }} {{  $product->state }} {{  $product->price }}
            <input type="number" name="quantity[]" min="0" max="{{  $product->stock }}">
        @endforeach
        

        <input type="submit" value="Confirm and Add">
        <input type="reset">
      </form>
</div>
@endsection