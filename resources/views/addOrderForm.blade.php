@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/admin/order" enctype="multipart/form-data" method="POST">
        @csrf
        
        <label for="userId">User ID:</label><br>
        <input type="text" id="userId" name="userId"><br>

        <label for="userName">User Name:</label><br>
        <input type="text" id="userName" name="userName"><br><br>

        @foreach ($product as $product)
            {{  $product->name }} {{  $product->state }} {{  $product->price }}
            <input type="number" id="quantity" name="quantity[]" min="0" max="{{  $product->stock }}">
        @endforeach

        <input type="submit" value="Confirm and Add">
        <input type="reset">
      </form>
</div>
@endsection