@extends('layouts.app')

@section('content')
<h2>Khách hàng</h2>
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
            <td><button type="button" class="btn btn-primary add-btn">
                Thêm Mới
              </button></td>
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                Import CSV
              </button></td>
            <td><a type="button" class="btn btn-primary" href="/customer/exportExcel">
                Export CSV
            </a></td>
            <td><input type="submit" value="Tìm kiếm">
                <input type="reset" value="Xóa tìm">
            </td>
        </tr>
        
    </table>
    </form>

    <div id="pagination">
        @include('customer.search')
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>

    <div class="modal fade" id="addCustomerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="/customer" id="addCustomerForm">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add Customer</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Họ và tên</label>
                            <div class="col-sm-9">
                                <input type="text" id="name" name="name" class="form-control" placeholder="Họ và tên người dùng">
                                <span id="warning-name" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                                <span id="warning-email" class="warning"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="tel_num" class="col-sm-3 col-form-label">Số điện thoại</label>
                            <div class="col-sm-9">
                                <input type="tel" id="tel_num" name="tel_num" class="form-control" placeholder="Số điện thoại">
                                <span id="warning-tel_num" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-sm-3 col-form-label">Địa chỉ</label>
                            <div class="col-sm-9">
                                <input type="text" id="address" name="address"class="form-control" placeholder="Địa chỉ">
                                <span id="warning-address" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label">Đang hoạt động?</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="state" name="state">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>

    <script type="text/javascript">
    $(document).ready(function () {
        function fetch_data(page, name, email, state, address)
        {
            $.ajax({
            url:"/customer/search?page="+page,
            type: 'get',
            data: {
                name:name,
                email:email,
                state:state,
                address:address
            },
            success:function(data)
                {
                    $('#pagination').html('');
                    $('#pagination').html(data);
                }
            })
        }

        $(document).on('submit', '#searchForm', function (e) {
            e.preventDefault();
            var searchName = $("#searchName").val();
            var searchEmail = $("#searchEmail").val();
            var searchState = $("#searchState").val();
            var searchAddress = $("#searchAddress").val();
            var page = $('#hidden_page').val();
            fetch_data(page, searchName, searchEmail, searchState, searchAddress);
        });

    
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            
            var searchName = $("#searchName").val();
            var searchEmail = $("#searchEmail").val();
            var searchState = $("#searchState").val();
            var searchAddress = $("#searchAddress").val();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, searchName, searchEmail, searchState, searchAddress);
        });

        $(document).on('click', '.add-btn', function() {
            $('#addCustomerModal').modal('show');

            $('#addCustomerForm').on('submit', function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var email = $("#email").val();
                var tel_num = $("#tel_num").val();
                var address = $("#address").val();
                var state;
                if ($('#state').is(':checked')) {
                    state = 1;
                }
                else {
                    state = 0;
                };
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
                    type: "POST",
                    url: "customer",
                    data: {
                        "_token": token,
                        name:name,
                        email:email,
                        tel_num:tel_num,
                        address:address,
                        state:state
                    },
                    success: function (result) {
                        if(result.errors) {
                            $(".warning").html("");
                            $.each( result.errors, function( key, value ) {
                                $("#warning-" + key).html("<a class='text-danger font-weight-bold'>" + value + "</a>");
                            });
                        }
                        else{
                            console.log(result.success);
                            location.reload();
                        }
                        
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });

        $(document).on('click', '.edit-btn', function() {
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            var id = $(this).data("id");

            $(this).parent().parent().children(".name").html($('<input>',{type:'text', value: data[0], form: 'editCustomer' + id, id: "editName"+id}));
            $(this).parent().parent().children(".email").html($('<input>',{type:'email', value: data[1], form: 'editCustomer' + id, id: "editEmail"+id}));
            $(this).parent().parent().children(".address").html($('<input>',{type:'text', value: data[2], form: 'editCustomer' + id, id: "editAddress"+id}));
            $(this).parent().parent().children(".telNum").html($('<input>',{type:'tel', value: data[3], form: 'editCustomer' + id, id: "editNum"+id}));
            $(this).replaceWith("<button type='submit' class='submit-edit-btn btn btn-success' form='editCustomer"+id+"'><i class='bi bi-save'></i></button>");

            $(document).on('submit', '.edit-customer-form', function(e) {
                e.preventDefault();
                var name = $("#editName"+id).val();
                var email = $("#editEmail"+id).val();
                var telNum = $("#editNum"+id).val();
                var address = $("#editAddress"+id).val();
                var token = $("meta[name='csrf-token']").attr("content");
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
                    success: function (result) {
                        if(result.errors) {
                            $(".warning").html("");
                            $.each( result.errors, function( key, value ) {
                                $("#warning-" + key +"-"+ id).html("<a class='text-danger font-weight-bold'>" + value + "</a>");
                            });
                        }
                        else{
                            console.log(result.success);
                            fetch_data(1, name, email);
                        }
                        
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