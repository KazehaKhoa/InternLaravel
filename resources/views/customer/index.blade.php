@extends('layouts.app')

@section('content')
<h2>Users</h2>
<hr>
<div class="container">
    <form id='searchForm'>
    <table class="table table-borderless">
        <tr>
            <th>Tên</th>
            <th>Email</th>
            <th>Trạng thái</th>
            <th>Địa chỉ</th>
        </tr>
        <tr>
            <td><input type="text" id="searchName" name="searchName"></td>
            <td><input type="email" id="serachEmail" name="searchEmail"></td>
            <td><select name="searchState" id="searchState">
                <option disabled selected value> -- hãy chọn trạng thái -- </option>
                <option value="0">Tạm khóa</option>
                <option value="1">Đang hoạt động</option>
                </select></td>
                <td><input type="text" id="searchAddress" name="searchAddress"></td>
        </tr>
        <tr>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCustomerModal">
                Thêm Mới
              </button></td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                Import CSV
              </button></td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                Export CSV
              </button></td>
            <td><input type="submit" value="Tìm kiếm">
                <input type="reset" value="Xóa tìm">
            </td>
        </tr>
    </table>
    </form>

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
                    <th class='cusId' scope="row">{{ $customer->id }}</th>
                    <td class="cusName">{{  $customer->customer_name }}</td>
                    <td class="cusMail">{{  $customer->email }}</td>
                    <td class="cusNum">{{  $customer->tel_num }}</td>
                    <td class="cusAddress">{{  $customer->address }}</td>
                    <td>
                        <button type="button" class="btn btn-primary edit-btn" data-id="{{ $customer->id }}"><i class="bi bi-pen"></i></button>        
                    </td>
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

    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="/customer">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" id="name" name="name" class="form-control" placeholder="Họ và tên người dùng">
                      <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                      <input type="tel" id="tel_num" name="tel_num" class="form-control" placeholder="Số điện thoại">
                      <input type="text" id="address" name="address"class="form-control" placeholder="Địa chỉ">
                      Đang hoạt động?
                      <input type="hidden" id="state" name="state" value="0" checked>
                      <input type="checkbox" id="state" name="state" value="1">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>

      <div class="modal fade" id="editCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editUser">
                @csrf
                <meta name="csrf-token" content="{{  csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id="editId" name="editId">
                      <input type="text" id="editName"  class="form-control" placeholder="Họ và tên người dùng">
                      <input type="email" id="editEmail"  class="form-control" placeholder="Email">
                      <input type="password" id="editPassword"  class="form-control" placeholder="Password">
                      <input type="password" id="editPassword_confirmation" class="form-control" placeholder=" Confirm Password">
                      <select name="editgroup" id="editGroup"  class="form-control">
                        <option disabled selected value> -- hãy chọn nhóm -- </option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="REVIEWER">REVIEWER</option>
                        <option value="EDITOR">EDITOR</option>
                      </select><br>
                      Lock?
                      <input type="checkbox" id="editState" name="editState">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" id="saveEditBtn">Save changes</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>

    <script type="text/javascript">
    $(document).ready(function () {
        $("#searchForm").submit(function (e) {
            e.preventDefault();
            var name = $("#searchName").val();
            var email = $("#searchEmail").val();
            var group = $("#searchGroup").val();
            var state = $("#searchState").val();
            $.ajax({
                type: "get",
                url: "/user/search",
                data: {
                    name:name,
                    email:email,
                    group:group,
                    state:state
                },
                dataType: "json",
                success: function (response) {
                    if(response) {
                        $("#listUser").html(response);
                        alert('haaah, kimochi yokatta');

                    }
                    else {
                        alert('i dont feel so good');
                    }
                }
            });
        });

        $('.edit-btn').on('click', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            alert(data[0] + data[1] + data[2] + data[3]);

            var id = $tr.children("th").map(function() {
                return $(this).text();
            }).get();
            alert(id[0]);

            $(this).parent().parent().children().eq(1).html($('<input>',{type:'text', value: data[0], form: 'editCustomer' + id[0], id: "editName"+id[0]}));
            $(this).parent().parent().children().eq(2).html($('<input>',{type:'text', value: data[1], form: 'editCustomer' + id[0], id: "editEmail"+id[0]}));
            $(this).parent().parent().children().eq(3).html($('<input>',{type:'text', value: data[2], form: 'editCustomer' + id[0], id: "editNum"+id[0]}));
            $(this).parent().parent().children().eq(4).html($('<input>',{type:'text', value: data[3], form: 'editCustomer' + id[0], id: "editAddress"+id[0]}));
            
            $(this).replaceWith("<button type='submit' class='submit-edit-btn' form='editCustomer"+id[0]+"'>Save</button>");

            alert("Fuiyo");
            
            


            $('.edit-customer-form').on('submit', function(e) {
                e.preventDefault;
                alert("Still OK");
                var name = $("#editName"+id[0]).val();
                alert(name);
                var email = $("#editEmail"+id[0]).val();
                alert(email);
                var telNum = $("#editNum"+id[0]).val();
                alert(telNum);
                var address = $("#editAddress"+id[0]).val();
                alert(address);
                var token = $("meta[name='csrf-token']").attr("content");
                alert("plz");
                $.ajax({
                    type: "POST",
                    url: "/customer/" +id,
                    data: {
                        "id": id,
                        "_method":"PATCH",
                        "_token": token,
                        name:name,
                        email:email,
                        telNum:telNum,
                        address:address,
                    },
                    success: function (response) {
                            alert("success");
                    },
                    error: function(error) {
                        console.log(error);
                        aler("Haiya");
                    }
                });
            });
        });
    });

    
    </script>

    
</div>
@endsection