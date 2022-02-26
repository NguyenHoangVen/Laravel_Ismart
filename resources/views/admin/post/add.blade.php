@extends('layouts.admin')
@section('title', 'Thêm bài viết')
@section('js')
    <script src='https://cdn.tiny.cloud/1/cidwq2xgtdduzb5r6ozsnlwcrcgg6crotyomx1jj7uzzfwh9/tinymce/4/tinymce.min.js'
        referrerpolicy="origin">
    </script>
    <script type="text/javascript" src="{{ asset('public/admins/js/tinymce.js') }}"></script>
    <script>

    </script>
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm bài viết
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title"
                            value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Ảnh bài viết</label>
                        <input id="img" type="file" name="image_post" class="form-control d-none"
                            onchange="changeImg(this)">
                        <img id="avatar" class="img-thumbnail d-block" width="300px"
                            src="{{ asset('public/admins/img/upload_img.png') }}">
                        @error('image_post')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control content @error('content') is-invalid @enderror"
                            id="content" cols="30" rows="5"
                            placeholder="Nhập nội dung bài viết">{{ old('content') }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select class="form-control @error('category_post_id') is-invalid @enderror" id=""
                            name="category_post_id">
                            <option value="">Chọn danh mục cho bài viết</option>
                            @foreach ($data_select as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('category_post_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios1" value="1"
                                checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="exampleRadios2" value="0">
                            <label class="form-check-label" for="exampleRadios2">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
