@extends('layouts.app')

@section('content')
<h2>Danh sách sản phẩm</h2>
<hr style="border: 1px solid #5bc0de">
<div class="container">
    <form id='searchForm'>
    <table class="table table-borderless">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Tình trạng</th>
            <th>Giá từ</th>
            <th>Đến</th>
        </tr>
        <tr>
            <td><input type="text" id="searchName" name="searchName"></td>
            <td><select name="searchState" id="searchState">
                <option disabled selected value> -- hãy chọn trạng thái -- </option>
                <option value="0">Ngừng bán</option>
                <option value="1">Đang bán</option>
                </select></td>
            <td><input type="number" id="fromPrice" name="fromPrice"></td>
            <td><input type="number" id="toPrice" name="toPrice"></td>
        </tr>
        <tr>
            <td><a type="button" class="btn btn-primary" href="/product/create">
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
        @include('product.search')
        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    </div>

    <script type="text/javascript">
    $(document).ready(function () {
        $(document).on('mouseenter', '.pop-image', function(){
            if ($(this).parent('td').children('td.image').length) {
                $(this).parent('td').children('td.image').show();
            } else {
                var image_name=$(this).data('image');
                var imageTag='<div class="image" style="position:absolute;">'+'<img src="'+image_name+'" alt="image" height="100" />'+'</div>';
                $(this).parent('td').append(imageTag);
            }
        });

        $(document).on('mouseleave', '.pop-image', function(){
            $(this).parent('td').children('div').remove();
        });
        
        function fetch_data(page, name, state, fromPrice, toPrice)
        {
            $.ajax({
                url:"/product/search?page="+page,
                type: 'get',
                data: {
                    name:name,
                    state:state,
                    fromPrice:fromPrice,
                    toPrice:toPrice
                },
                success:function(data)
                    {  
                        console.log(data);
                        $('#pagination').html('');
                        $('#pagination').html(data);
                    },
                error:function(err)
                {
                    console.log(err);
                }
            })
        }

        $(document).on('submit', '#searchForm', function (e) {
            e.preventDefault();
            var searchName = $("#searchName").val();
            var searchState = $("#searchState").val();
            var fromPrice = $("#fromPrice").val();
            var toPrice = $("#toPrice").val();
            var page = $('#hidden_page').val();
            console.log(searchName + searchState);
            fetch_data(page, searchName, searchState, fromPrice, toPrice);
        });

    
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            
            var searchName = $("#searchName").val();
            var searchState = $("#searchState").val();
            var fromPrice = $("#fromPrice").val();
            var toPrice = $("#toPrice").val();
            $('li').removeClass('active');
            $(this).parent().addClass('active');
            fetch_data(page, searchName, searchState, fromPrice, toPrice);
        });

        $(document).on('click', '.delete-product', function(e) {
            e.preventDefault();
            var product_id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");
            
            $.ajax({
                type: "POST",
                url: "product/"+product_id + "/delete",
                data: {
                    "id": product_id,
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
    });

    
    </script>

    
</div>
@endsection