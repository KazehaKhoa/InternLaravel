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
                <th scope="row">{{  ($users->currentpage()-1) * $users->perpage() + $loop->index + 1 }}</th>
                <td>{{  $user->name }}</td>
                <td>{{  $user->email }}</td>
                <td>{{  $user->group }}</td>
                @if ($user->state == 1)
                    <td class="text-success">Đang hoạt động</td>
                @else
                    <td class="text-danger">Tạm khóa</td>
                @endif
                <td>
                    <button type="button" class="btn btn-primary edit-btn" data-id="{{  $user->id }}"><i class="bi bi-pen"></i></button>
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