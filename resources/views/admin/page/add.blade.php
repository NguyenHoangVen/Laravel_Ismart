@extends('layouts.admin')
@section('title', 'Thêm trang')
@section('js')
    <script src='https://cdn.tiny.cloud/1/cidwq2xgtdduzb5r6ozsnlwcrcgg6crotyomx1jj7uzzfwh9/tinymce/4/tinymce.min.js'
        referrerpolicy="origin">
    </script>
    <script type="text/javascript" src="{{ asset('public/admins/js/tinymce.js') }}"></script>
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Thêm Trang
            </div>
            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tiêu đề trang</label>
                        <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}">
                        @error('title')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="content">Nội dung trang</label>
                        <textarea name="content" class="form-control content" id="content" cols="30" rows="8"></textarea>
                        @error('content')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                </form>
            </div>
        </div>
    </div>
@endsection
