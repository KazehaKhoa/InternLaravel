<div id="top-pagination"class="d-flex justify-content-center">
    {!! $products->links() !!}
</div>

<table class="mt-5 table table-light" id="userTable">
    <tr class="bg-danger text-light">
        <th scope="col" style="width: 5%">#</th>
        <th scope="col" style="width: 15%">Tên sản phẩm</th>
        <th scope="col" style="width: 45%">Mô tả</th>
        <th scope="col" style="width: 10%">Giá</th>
        <th scope="col" style="width: 15%">Tình trạng</th>
        <th></th>
    </tr>
    <tbody id="listUser">
        @foreach ($products as $product)
            <tr class="font-weight-bold">
                <th scope="row">{{  ($products->currentpage()-1) * $products->perpage() + $loop->index + 1 }}</th>
                <td><a class="pop-image" data-image="{{ $product->product_image }}">{{  $product->product_name }}</a></td>
                <td>{{  $product->description }}</td>
                <td>{{  $product->product_price }}</td>
                @if ($product->is_sales == 1)
                    <td class="text-success">Còn hàng</td>
                @else
                    <td class="text-danger">Hết hàng</td>
                @endif
                <td>
                    <a type="button" class="btn btn-primary" href="/product/{{ $product->id }}/edit"><i class="bi bi-pen"></i></a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal{{ $product->id }}"><i class="bi bi-trash"></i></button>                      
                </td>
            </tr>

            <div class="modal fade" id="confirmDeleteModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Delete Product</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                        <a class="text-danger font-weight-bold">WARNING!!</a>
                        <br>
                        <a id="warning">Do you want to delete product {{ $product->product_name }}?</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <meta name="csrf-token" content="{{  csrf_token() }}">
                        <button type="submit" class="btn btn-danger delete-product" data-id="{{ $product->id }}">Delete</button>
                    </div>
                  </div>
                </div>
              </div>
        @endforeach
    </tbody>
</table>
<br>
<div id="bot-pagination" class="d-flex justify-content-center">
    {!! $products->links() !!}
</div>