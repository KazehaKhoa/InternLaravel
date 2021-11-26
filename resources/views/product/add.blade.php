@extends('layouts.app')

@section('content')
<h2 class="ml-5">ADD PRODUCT</h2>
<hr style="border: 1px solid #5bc0de">
<form action="/product" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-4">
            <div class="form-group row ml-2">
                <label for="name" class="col-sm-3 col-form-label">Tên sản phẩm</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nhập tên sản phẩm" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <strong style="color:red">{{ $errors->first('name') }}</strong>
                    @endif
                </div>
            </div>

            <div class="form-group row ml-2">
                <label for="price" class="col-sm-3 col-form-label">Giá bán</label>
                <div class="col-sm-9">
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Nhập giá bán" value="{{ old('price') }}">
                    @if ($errors->has('price'))
                    <strong style="color:red">{{ $errors->first('price') }}</strong>
                    @endif
                </div>
            </div>

            <div class="form-group row ml-2">
                <label for="description" class="col-sm-3 col-form-label">Mô tả</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="description" name="description" rows="5" placeholder="Nhập mô tả sản phẩm"></textarea>
                </div>
            </div>

            <div class="form-group row ml-2">
                <label for="state" class="col-sm-3 col-form-label">Trạng thái</label>
                <div class="col-sm-9">
                    <select class="form-control @error('state') is-invalid @enderror" name="state" id="state">
                        <option disabled selected value> -- hãy chọn nhóm -- </option>
                        <option value="1">Đang bán</option>
                        <option value="0">Ngừng bán</option>
                        <option value="0">Hết hàng</option>
                    </select>
                    @if ($errors->has('state'))
                    <strong style="color:red">{{ $errors->first('state') }}</strong>
                    @endif
                </div>
            </div>
        </div>

        <div class=col-md-1>
        </div>

        <div class="col-md-6">
            <div class="ml-1">Hình ảnh</div>
            <div class="temp-img"><img src="/svg/blank-image.png" style="height: 200px; width:300px;" class="rounded mt-3 ml-5"></div>
            <div class="input-group mt-4 row">
                <div class="col-md-1">
                    <button class="btn btn-danger" type="button" id="deleteFile">Delete</button>
                </div>
                <div class="custom-file col-md-5 col-md-offset-6">
                  <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                  @if ($errors->has('file'))
                    <strong style="color:red">{{ $errors->first('file') }}</strong>
                    @endif
                </div>
              </div>

              
            
            <div class="row mt-5">
                <div class="col md-4"></div> 
                <div class="col md-1">
                    <a type="button" class="btn  btn-secondary btn-lg" href="/product">Hủy</a>
                </div>
                
                <div class="col-md-2">
                    <input type="submit" class="btn btn-danger btn-lg" value="    Lưu    ">
                </div>
                <div class="col-md-5"></div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#deleteFile').click(function (e) { 
            e.preventDefault();
            $('#file').val('');
        });
    });
</script>
@endsection