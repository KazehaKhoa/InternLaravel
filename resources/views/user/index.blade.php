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
            <th>Nhóm</th>
            <th>Trạng thái</th>
        </tr>
        <tr>
            <td><input type="text" id="searchName" name="searchName"></td>
            <td><input type="email" id="serachEmail" name="searchEmail"></td>
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
            <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
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

    <div id="top-pagination"class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>

    <table class="mt-5 table table-light" id="userTable">
        <tr class="bg-danger text-light">
            <th scope="col">#</th>
            <th scope="col">Họ Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Nhóm</th>
            <th scope="col">Trạng thái</th>
            <th></th>
        </tr>
        <tbody id="listUser">
            @foreach ($users as $user)
                <tr class="font-weight-bold">
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{  $user->name }}</td>
                    <td>{{  $user->email }}</td>
                    <td>{{  $user->group }}</td>
                    @if ($user->state == 1)
                        <td class="text-success">Đang hoạt động</td>
                    @else
                        <td class="text-danger">Tạm khóa</td>
                    @endif
                    <td>
                        <button type="button" class="btn btn-primary edit-btn"><i class="bi bi-pen"></i></button>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $user->id }}"><i class="bi bi-trash"></i></button>
                        <button type="button" class="btn btn-secondary lock-btn" data-id="{{  $user->id }}"><i class="bi bi-lock"></i></button>                       
                    </td>
                </tr>

                <div class="modal fade" id="confirmDeleteModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Delete User</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <a class="text-danger font-weight-bold">WARNING!!</a>
                            <br>
                            <a id="warning">Do you want to delete user {{ $user->id }}?</a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <meta name="csrf-token" content="{{  csrf_token() }}">
                            <button type="submit" class="btn btn-danger delete-user" data-id="{{ $user->id }}">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
            @endforeach
        </tbody>
    </table>
    <br>
    <div id="bot-pagination" class="d-flex justify-content-center">
        {!! $users->links() !!}
    </div>

    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="/user">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <input type="text" id="name" name="name" class="form-control" placeholder="Họ và tên người dùng">
                      <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                      <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                      <input type="password" id="password_confirmation" name="password_confirmation"class="form-control" placeholder="Confirm Password">
                      <select name="group" id="group" class="form-control">
                        <option disabled selected value> -- hãy chọn nhóm -- </option>
                        <option value="ADMIN">ADMIN</option>
                        <option value="REVIEWER">REVIEWER</option>
                        <option value="EDITOR">EDITOR</option>
                      </select><br>
                      Lock?
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

      <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        $('.delete-user').click(function(e) {
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

        $('.edit-btn').on('click', function() {
            $('#editUserModal').modal('show');

            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            var id = $tr.children("th").map(function() {
                return $(this).text();
            }).get();
            
            $('editId').val(id[0]);

            $('#editUser').on('submit', function(e) {
                e.preventDefault;
                var user_id = id[0];
                var name = $("#editName").val();
                var email = $("#editEmail").val();
                var password = $("#editPassword").val();
                var group = $("#editGroup").val();
                var state;
                if ($('#editState').is(':checked')) {
                    state = 0;
                }
                else {
                    state = 1;
                };
                var token = $("meta[name='csrf-token']").attr("content");
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
                        group:group,
                        state:state
                    },
                    success: function (response) {
                            $('editUserModal').modal('hide');
                            alert("success");
                    },
                    error: function(error) {
                        alert(error);
                    }
                });
            });
        });

        $('.lock-btn').on('click', function() {
            $('#confirmLockModal').modal('show');

            

            var id = $(this).data('id');
            
            $('lockId').val(id);
            var token = $("meta[name='csrf-token']").attr("content");

            $('#lockUser').on('submit', function(e) {
                e.preventDefault();
                var user_id = id;
                $.ajax({
                    type: "POST",
                    url: "user/"+id+"/lock",
                    data: {
                        "id": id,
                        "_method":"PATCH",
                        "_token": token
                    },
                    success: function (response) {
                            $('confirmLockModal').modal('hide');
                            alert("success");
                            location.reload();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    });

    
    </script>

    
</div>
@endsection