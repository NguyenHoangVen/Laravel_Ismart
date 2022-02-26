@extends('layouts.admin')
@section('title', 'Sửa bài viết')
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
                Sửa bài viết
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề bài viết</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title"
                            value="{{ $post->title }}" placeholder="Nhập tiêu đề bài viết">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Ảnh bài viết</label>
                        <input id="img" type="file" name="image_post" class="form-control d-none"
                            onchange="changeImg(this)">
                        <img id="avatar" class="img-thumbnail d-block" width="300px" src="{{ asset($post->image_post) }}">
                        @error('image_post')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" class="form-control content @error('content') is-invalid @enderror"
                            id="content" cols="30" rows="5">{{ $post->content }}</textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>


                    <div class="form-group">
                        <label for="">Danh mục</label>
                        <select class="form-control @error('category_post_id') is-invalid @enderror" id=""
                            name="category_post_id">
                            @foreach ($data_select as $key => $value)
                                @if ($post->category_post_id == $key)
                                    <option selected value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>
                        @error('category_post_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" @if ($post->status == 1) checked @endif type="radio" name="status" value="1" id="public">
                            <label class="form-check-label" for="public">
                                Công khai
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" @if ($post->status == 0) checked @endif type="radio" name="status" value="0" id="pending">
                            <label class="form-check-label" for="pending">
                                Chờ duyệt
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
