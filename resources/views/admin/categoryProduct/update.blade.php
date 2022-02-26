@extends('layouts.admin')
@section('title', 'Sửa danh mục sản phẩm')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh mục sản phẩm
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                    id="name" value="{{ $category->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select class="form-control" id="" name="parent_id">
                                    <option value="0">Danh mục cha</option>
                                    @foreach ($data_select as $key => $val)
                                        @if ($category->parent_id == $key)
                                            <option selected value="{{ $key }}">{{ $val }}</option>
                                        @else
                                            @if ($category->id == $key)
                                                <option hidden value="{{ $key }}">{{ $val }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
