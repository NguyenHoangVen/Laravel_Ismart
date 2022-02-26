@extends('layouts.admin')
@section('title', 'Cập nhật sản phẩm')
@section('js')
<script src='https://cdn.tiny.cloud/1/cidwq2xgtdduzb5r6ozsnlwcrcgg6crotyomx1jj7uzzfwh9/tinymce/4/tinymce.min.js'
referrerpolicy="origin">
</script>
<script type="text/javascript" src="{{ asset('public/admins/js/tinymce.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/admins/js/addcolor.js') }}"></script>
@endsection
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật sản phẩm
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                        value="{{ $product->name }}" placeholder="Nhập tên sản phẩm">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Ảnh sản phẩm</label>
                    <input id="img" type="file" name="feature_image" class="form-control d-none"
                        onchange="changeImg(this)">
                    <img id="avatar" class="img-thumbnail d-block" width="200px"
                        src="{{ asset($product->feature_image) }}">
                    @error('feature_image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="">Ảnh chi tiết về sản phẩm</label>
                    <input type="file" multiple class="form-control-file" name="image_product[]"
                        value="{{ old('image_product[]') }}">
                    @error('image_product')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    @error('image_product.*')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="user-image mb-3 text-center">
                    <div class="imgPreview">
                        @foreach ($productImage as $item)
                            <img src="{{ asset($item->image_product) }}" alt="{{ $item->image_name }}">
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="price">Giá sản phẩm</label>
                    <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                        value="{{ $product->price }}" id="price" placeholder="Nhập giá sản phẩm">
                    @error('price')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control content @error('description') is-invalid @enderror"
                        id="content" cols="30" rows="5"
                        placeholder="Nhập nội dung bài viết">{{ $product->description }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_product_id">Danh mục</label>
                    <select class="form-control @error('category_product_id') is-invalid @enderror"
                        id="category_product_id" name="category_product_id">
                        @foreach ($data_select as $key => $value)
                            <option {{ $product->category_product_id == $key ? 'selected' : '' }}
                                value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('category_product_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" {{ $product->status == 1 ? 'checked' : '' }} type="radio"
                                name="status" id="exampleRadios1" value="1">
                            <label class="form-check-label" for="exampleRadios1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" {{ $product->status == 0 ? 'checked' : '' }} type="radio"
                                name="status" id="exampleRadios2" value="0">
                            <label class="form-check-label" for="exampleRadios2">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Sản phẩm nổi bật</label>
                        <div class="form-check">
                            <input class="form-check-input" {{ $product->featured == 0 ? 'checked' : '' }}
                                type="radio" name="featured" id="No" value="0" checked>
                            <label class="form-check-label" for="No">
                                No
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" {{ $product->featured == 1 ? 'checked' : '' }}
                                type="radio" name="featured" id="yes" value="1">
                            <label class="form-check-label" for="yes">
                                Yes
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection
