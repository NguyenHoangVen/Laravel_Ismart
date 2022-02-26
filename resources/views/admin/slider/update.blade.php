@extends('layouts.admin')
@section('title', 'Cập nhật slider')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Cập nhật slider
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Ảnh slider</label>
                                <input id="img" type="file" name="image_path" class="form-control d-none"
                                    onchange="changeImg(this)">
                                <img id="avatar" class="img-thumbnail d-block" width="250px"
                                    src="{{ asset($slider->image_path) }}">
                                @error('image_path')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" @if ($slider->status == 1) checked @endif type="radio" name="status" value="1"
                                        id="public">
                                    <label class="form-check-label" for="public">
                                        Công khai
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" @if ($slider->status == 0) checked @endif type="radio" name="status" value="0"
                                        id="pending">
                                    <label class="form-check-label" for="pending">
                                        Chờ duyệt
                                    </label>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Cập nhật">
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
