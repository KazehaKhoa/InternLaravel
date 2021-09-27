@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center"><h3>OrderId: {{  $order->id }}</h3></div>
    <form action="/order/{{ $order->id }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('PATCH')
        <table>
            <tr>
                <td>User ID:<br></td>
                <td>{{ $order->user->id }}</td>
            </tr>

            <tr>
                <td>User Name:<br></td>
                <td>{{ $order->user->name }}</td>
            </tr>

            <tr>
                <td>Sum:<br></td>
                <td>{{ $order->sum }}</td>
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
        
        <input type="submit" value="Confirm Edit">
      </form>
    
</div>
@endsection