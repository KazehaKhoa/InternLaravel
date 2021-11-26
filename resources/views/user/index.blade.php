@extends('layouts.app')

@section('content')
<h2>Users</h2>
<hr>
<div class="container">
    <form id='searchForm' method="GET" action="/user/search">
    <table class="table table-borderless">
        <tr>
            <th>Tên</th>
            <th>Email</th>
            <th>Nhóm</th>
            <th>Trạng thái</th>
        </tr>
        <tr>
            <td><input type="text" id="searchName" name="searchName"></td>
            <td><input type="email" id="searchEmail" name="searchEmail"></td>
            <td><select name="searchGroup" id="searchGroup">
                <option disabled selected value> -- hãy chọn nhóm -- </option>
                <option value="ADMIN">ADMIN</option>
                <option value="REVIEWER">REVIEWER</option>
                <option value="EDITOR">EDITOR</option>
              </select>
            </td>
            <td><select name="searchState" id="searchState">
                <option disabled selected value> -- hãy chọn trạng thái -- </option>
                <option value="0">Tạm khóa</option>
                <option value="1">Đang hoạt động</option>
                </select></td>
        </tr>
        <tr>
            <td><button type="button" class="btn btn-primary add-btn">
                Thêm Mới
              </button></td>
            <td></td>
            <td></td>
            <td><input type="submit" value="Tìm kiếm">
                <input type="reset" value="Xóa tìm">
            </td>
        </tr>
    </table>
    </form>

    <div id="pagination">
        @include('user.search')
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="/user" id="addUserForm">
                @csrf
                <meta name="csrf-token" content="{{  csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
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
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                                <span id="warning-password" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="password_confirmation" name="password_confirmation"class="form-control" placeholder="Confirm Password">
                                <span id="warning-password_confirmation" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="group" class="col-sm-3 col-form-label">Group</label>
                            <div class="col-sm-9">
                                <select name="group" id="group" class="form-control">
                                    <option disabled selected value> -- hãy chọn nhóm -- </option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="REVIEWER">REVIEWER</option>
                                    <option value="EDITOR">EDITOR</option>
                                </select>
                                <span id="warning-group" class="warning"></span>
                            </div>
                        </div>
                      
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label">Lock?</label>
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

      <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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

                        <div class="form-group row">
                            <label for="editName" class="col-sm-3 col-form-label">Họ và tên</label>
                            <div class="col-sm-9">
                                <input type="text" id="editName"  class="form-control" placeholder="Họ và tên người dùng">
                                <span id="warning-edit-name" class="warning"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="editEmail" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input type="email" id="editEmail"  class="form-control" placeholder="Email">
                                <span id="warning-edit-email" class="warning"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="editPassword" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="editPassword"  class="form-control" placeholder="Password">
                                <span id="warning-edit-password" class="warning"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="editPassword_confirmation" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <input type="password" id="editPassword_confirmation" class="form-control" placeholder=" Confirm Password">
                                <span id="warning-edit-confirmation" class="warning"></span>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="editgroup" class="col-sm-3 col-form-label">Confirm Password</label>
                            <div class="col-sm-9">
                                <select name="editgroup" id="editGroup"  class="form-control">
                                    <option disabled selected value> -- hãy chọn nhóm -- </option>
                                    <option value="ADMIN">ADMIN</option>
                                    <option value="REVIEWER">REVIEWER</option>
                                    <option value="EDITOR">EDITOR</option>
                                </select>
                                <span id="warning-edit-group" class="warning"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="editState" class="col-sm-3 col-form-label">Lock?</label>
                            <div class="col-sm-9">
                                <input type="checkbox" id="editState" name="editState">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" id="saveEditBtn">Save changes</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>

      <div class="modal fade" id="confirmLockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="lockUser">
                @csrf
                @method('PATCH')
                <meta name="csrf-token" content="{{  csrf_token() }}">
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">LOCK/UNLOCK User</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" id="lockId" name="lockId">
                      Do you want to change state of this user?
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" id="saveLockBtn">Save changes</button>
                    </div>
                  </div>
            </form>
        </div>
      </div>

    <script type="text/javascript">
    $(document).ready(function () {
        function fetch_data(page, name, email, group, state)
        {
            $.ajax({
            url:"/user/search?page="+page,
            type: 'get',
            data: {
                name:name,
                email:email,
                group:group,
                state:state
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
            var searchGroup = $("#searchGroup").val();
            var searchState = $("#searchState").val();
            var page = $('#hidden_page').val();
            fetch_data(page, searchName, searchEmail, searchGroup, searchState);
        });

    
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            
            var searchName = $("#searchName").val();
            var searchEmail = $("#searchEmail").val();
            var searchGroup = $("#searchGroup").val();
            var searchState = $("#searchState").val();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, searchName, searchEmail, searchGroup, searchState);
        });


        $('.add-btn').on('click', function() {
            $('#addUserModal').modal('show');

            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var confirm = $("#password_confirmation").val();
                var group = $("#group").val();
                var state;
                if ($('#state').is(':checked')) {
                    state = 0;
                }
                else {
                    state = 1;
                };
                var token = $("meta[name='csrf-token']").attr("content");
                
                $.ajax({
                    type: "POST",
                    url: "user",
                    data: {
                        "_token": token,
                        name:name,
                        email:email,
                        password:password,
                        password_confirmation:confirm,
                        group:group,
                        state:state
                    },
                    success: function (result) {
                        if(result.errors) {
                            $(".warning").html("");
                            console.log(result.errors);
                            $.each( result.errors, function( key, value ) {
                                $("#warning-" + key).html("<a class='text-danger font-weight-bold'>" + value + "</a>");
                                console.log(value);
                            });
                        }
                        else{
                            console.log(result.success);
                            location.reload();
                        }
                        
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            });
        });

        $(document).on('click', '.delete-user', function(e) {
            e.preventDefault();
            var user_id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                type: "POST",
                url: "user/"+user_id + "/delete",
                data: {
                    "id": user_id,
                    "_token": token,
                    "_method": 'DELETE',
                },
                success: function (response) {
                    if(response) {
                        $('.modal').modal('hide');
                        location.reload();
                    }
                    else {
                        alert('i dont feel so good');
                    }
                }
            });
        }) ;

        $(document).on('click', '.edit-btn', function() {
            var i = 0;
            $('#editUserModal').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();
            console.log(data);
            $('#editName').val(data[0]);
            $('#editEmail').val(data[1]);
            $('#editGroup').val(data[2]);
            if(data[3] == "Tạm khóa") {
                $('#editState').prop('checked', true);
            } else {
                $('#editState').prop('checked', false);
            }

            var id = $(this).data('id');
            
            $('editId').val(id);

            $(document).on('submit', '#editUser', function(e) {
                e.preventDefault();
                i++;
                console.log(i);
                var name = $("#editName").val();
                var email = $("#editEmail").val();
                var password = $("#editPassword").val();
                var confirmation = $("#editPassword_confirmation").val();
                var group = $("#editGroup").val();
                var state;
                if ($('#editState').is(':checked')) {
                    state = 0;
                }
                else {
                    state = 1;
                };
                var token = $("meta[name='csrf-token']").attr("content");
                if(i == 1) {
                    $.ajax({
                        type: "POST",
                        url: "user/"+id,
                        data: {
                            "id": id,
                            "_method":"PATCH",
                            "_token": token,
                            name:name,
                            email:email,
                            password:password,
                            confirmation:confirmation,
                            group:group,
                            state:state
                        },
                        success: function (result) {
                            $(".warning").html("");
                            if(result.errors) {
                                console.log(result.errors);
                                $.each( result.errors, function( key, value ) {
                                    $("#warning-edit-" + key).html("<a class='text-danger font-weight-bold'>" + value + "</a>");
                                });
                                i--;
                            }
                            else{
                                console.log(result.success);
                                console.log(name, email);
                                fetch_data(1, name, email);
                                $('#editUserModal').modal('hide');
                            }
                            
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
            });
        });

        $(document).on('click', '.lock-btn', function() {
            $('#confirmLockModal').modal('show');

            var id = $(this).data('id');
            
            $('lockId').val(id);
            var token = $("meta[name='csrf-token']").attr("content");
            var i = 0;

            $('#lockUser').on('submit', function(e) {
                e.preventDefault();
                i++;
                if(i == 1) {
                    $.ajax({
                        type: "POST",
                        url: "user/"+id+"/lock",
                        data: {
                            "id": id,
                            "_method":"PATCH",
                            "_token": token
                        },
                        success: function (response) {
                                $('#confirmLockModal').modal('hide');
                                console.log("Check");
                                fetch_data(1, '', response.email);
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                }
                
            });
        });
    });
    
    </script>

    
</div>
@endsection