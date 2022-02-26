@extends('layouts.admin')
@section('title', 'Danh sách slider')
@section('content')
<div id="content" class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm slider
                </div>
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Ảnh slider</label>
                            <input id="img" type="file" name="image_path" class="form-control d-none" onchange="changeImg(this)">
                            <img id="avatar" class="img-thumbnail d-block" width="250px" src="{{ asset('public/admins/img/upload_img.png') }}">
                            @error('image_path')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="1" checked>
                                <label class="form-check-label" for="exampleRadios1">
                                    Công khai
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="0">
                                <label class="form-check-label" for="exampleRadios2">
                                    Chờ duyệt
                                </label>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Thêm mới">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách slider
                </div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="analytic">
                        <a href="{{ route('slider.list') }}?status=all" class="text-primary {{$status == ''?'active':''}}">Tất cả
                            <span class="text-muted">({{ $count['all'] }})</span></a>
                        <a href="{{ route('slider.list') }}?status=public" class="text-primary {{$status == 'public'?'active':''}}">Công
                            khai<span class="text-muted">({{ $count['public'] }})</span></a>
                        <a href="{{ route('slider.list') }}?status=pending" class="text-primary {{$status == 'pending'?'active':''}}">Chờ
                            duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                        <a href="{{ route('slider.list') }}?status=trash" class="text-primary {{$status == 'trash'?'active':''}}">Vô hiệu
                            hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
                    </div>
                    <form action="{{ route('slider.action') }}">
                        <div class="form-action form-inline py-3">
                            <select class="form-control mr-1" id="" name="act">
                                <option value="">Chọn</option>
                                @foreach ($list_act as $key => $val)
                                <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        </div>
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input name="checkall" type="checkbox">
                                    </th>
                                    <th scope="col">#</th>
                                    <th scope="col" width="20%">Ảnh slider</th>
                                    <th scope="col">Người tạo</th>
                                    <th scope="col">Ngày tạo</td>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sliders->count() > 0)
                                @php
                                $t = 1;
                                @endphp
                                @foreach ($sliders as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <td scope="row">{{ $t++ }}</td>
                                    <td><img class="img-thumbnail" src="{{ asset($item->image_path) }}" alt=""></td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('slider.update', ['id' => $item->id]) }}" class="btn btn-success btn-sm text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                        @if (request()->status != 'trash')
                                        <a href="{{ route('slider.delete', ['id' => $item->id]) }}" onclick="return confirm('Bán có chắc chắn muốn xóa tạm bản ghi này')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                        @endif
                                       
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8">Không có bản ghi nào</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </form>
                    {{ $sliders->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection