@extends('layouts.admin')
@section('title', 'Thêm bài viết')
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
            Thêm sản phẩm
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name"
                        value="{{ old('name') }}" placeholder="Nhập tên sản phẩm">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Ảnh sản phẩm</label>
                            <input id="img" type="file" name="feature_image" class="form-control d-none"
                                onchange="changeImg(this)">
                            <img id="avatar" class="img-thumbnail d-block" width="200px"
                                src="{{ asset('public/admins/img/upload_img.png') }}">
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
                        <div class="form-group">
                            <label for="price">Giá sản phẩm</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price"
                                value="{{ old('price') }}" id="price" placeholder="Nhập giá sản phẩm">
                            @error('price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>Màu và ảnh về sản phẩm</label>
                            <div class="input_fields_wrap">
                                <button class="btn btn-info add_field_button mb-2">Thêm màu</button>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="">Màu của sản phẩm</label>
                                        @error('name_color.*')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <input type="text"
                                            class="form-control @error('name_color') is-invalid @enderror"
                                            name="name_color[]" placeholder="Nhập màu sản phẩm">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="">Ảnh màu sản phẩm</label>
                                        @error('image_color_path')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @error('image_color_path.*')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        <input type="file" class="form-control-file" name="image_color_path[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả sản phẩm</label>
                    <textarea name="description" class="form-control content @error('description') is-invalid @enderror"
                        id="content" cols="30" rows="5"
                        placeholder="Nhập nội dung bài viết">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="category_product_id">Danh mục</label>
                    <select class="form-control @error('category_product_id') is-invalid @enderror"
                        id="category_product_id" name="category_product_id">
                        <option value="">Chọn danh mục cho bài viết</option>
                        @foreach ($data_select as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
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
                            <input class="form-check-input" type="radio" name="status" id="public1" value="1" checked>
                            <label class="form-check-label" for="public1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="pending1" value="0">
                            <label class="form-check-label" for="pending1">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Sản phẩm nổi bật</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="featured" id="No" value="0" checked>
                            <label class="form-check-label" for="No">
                                No
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="featured" id="yes" value="1">
                            <label class="form-check-label" for="yes">
                                Yes
                            </label>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection
