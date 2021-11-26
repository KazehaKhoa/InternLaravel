<div id="top-pagination"class="d-flex justify-content-center">
    {!! $customers->links() !!}
</div>

<table class="mt-5 table table-light" id="userTable">
    <tr class="bg-danger text-light">
        <th scope="col">#</th>
        <th scope="col">Họ Tên</th>
        <th scope="col">Email</th>
        <th scope="col">Địa chỉ</th>
        <th scope="col">Điện thoại</th>
        <th></th>
    </tr>
    <tbody id="listUser">
        @foreach ($customers as $customer)
            <tr class="font-weight-bold">
                <th class='cusId' scope="row">{{ $loop->iteration }}</th>
                <td class="name" id="name{{ $customer->id }}">{{  $customer->customer_name }}</td>
                <td class="email" id="email{{ $customer->id }}">{{  $customer->email }}</td>
                <td class="address" id="address{{ $customer->id }}">{{  $customer->address }}</td>
                <td class="telNum" id="telNum{{ $customer->id }}">{{  $customer->tel_num }}</td>
                <td>
                    <button type="button" class="btn btn-primary edit-btn" data-id="{{ $customer->id }}"><i class="bi bi-pen"></i></button>        
                </td>
            </tr>

            <tr>
                <td class="warning">&nbsp;</td>
                <td id="warning-name-{{ $customer->id }}" class="warning">&nbsp;</td>
                <td id="warning-email-{{ $customer->id }}" class="warning">&nbsp;</td>
                <td id="warning-address-{{ $customer->id }}" class="warning">&nbsp;</td>
                <td id="warning-telNum-{{ $customer->id }}" class="warning">&nbsp;</td>
            </tr>

            <form id="editCustomer{{ $customer->id }}" class="edit-customer-form">
                @csrf
                <meta name="csrf-token" content="{{  csrf_token() }}">
            </form>
        @endforeach
    </tbody>
</table>
<br>
<div id="bot-pagination" class="d-flex justify-content-center">
    {!! $customers->links() !!}
</div>