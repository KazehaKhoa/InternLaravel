@extends('layouts.app')

@section('content')
<div class="container">
    <form action="/admin/order" enctype="multipart/form-data" method="POST">
        @csrf
        
        <table>
            <tr>
                <td><label for="userId">User ID:</label><br></td>
                <td><input type="text" class="form-control" id="userId" name="userId"><br></td>

                @if ($errors->has('userId'))
                    <strong style="color:red">{{ $errors->first('userId') }}</strong>
                @endif
            </tr>
            <tr>
                <td> <label for="orderState">Order Description:</label><br></td>
                <td><select name="orderState" id="orderState">
                        <option value="SHIPPING">SHIPPING</option>
                        <option value="CANCELLED">CANCELLED</option>
                        <option value="FINISHED">FINISHED</option>
                    </select></td>
            </tr>
        </table>
        
        <table class="table table-light">
            <tr>
                <th>Product</th>
                <th>State</th>
                <th>Price</th>
            </tr>
            @foreach ($product as $product)
            <tr>
                <td>{{  $product->name }}</td>  <td>{{  $product->state }}</td>  <td>{{  $product->price }}</td>
            </tr>
            <tr>
                <td>Amount:</td>
                <td><input type="number" class="form-control" name="quantity[]" min="0" max="{{  $product->stock }}"></td>
            </tr>
            @endforeach
        </table>
        

        <input type="submit" value="Confirm and Add">
      </form>
</div>
@endsection