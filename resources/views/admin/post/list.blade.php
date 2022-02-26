@extends('layouts.admin')
@section('title', 'Danh sách bài viết')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách bài viết</h5>
            <div class="form-search form-inline">
                <form action="">
                    <input type="text" class="form-control form-search" name="kw" placeholder="Tìm kiếm tiêu đề bài viết" value="{{ request()->kw }}">
                    <input type="submit" value="Tìm kiếm" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors') }}
            </div>
            @endif
            <div class="analytic">
                <a href="{{ route('post.list') }}?status=all" class="text-primary {{$status == ''?'active':''}}">Tất cả
                    <span class="text-muted">({{ $count['all'] }})</span></a>
                <a href="{{ route('post.list') }}?status=public" class="text-primary {{$status == 'public'?'active':''}}">Công
                    khai<span class="text-muted">({{ $count['public'] }})</span></a>
                <a href="{{ route('post.list') }}?status=pending" class="text-primary {{$status == 'pending'?'active':''}}">Chờ
                    duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                <a href="{{ route('post.list') }}?status=trash" class="text-primary {{$status == 'trash'?'active':''}}">Vô hiệu
                    hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
            </div>
            <form action="{{ route('post.action') }}">
                <div class="form-action form-inline py-3">
                    @if (Auth::user()->can('sua-bai-viet'))
                    <select class="form-control mr-1" id="" name="act">
                        <option value="">Chọn</option>
                        @foreach ($list_act as $key => $val)
                        <option value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    @endif
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col" width="15%">Ảnh</th>
                            <th scope="col" width="30%">Tiêu đề</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($posts->count() > 0)
                        @php
                        $t = 1;
                        @endphp
                        @foreach ($posts as $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                            </td>
                            <td scope="row">{{ $t++ }}</td>
                            <td><img class="img-thumbnail" src="{{ asset($item->image_post) }}" alt="">
                            </td>
                            <td>{{ $item->title }}</td>
                            <td>{{ $item->category->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td>
                                @if (Auth::user()->can('sua-bai-viet'))
                                <a href="{{ route('post.update', ['id' => $item->id]) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>
                                @endif
                                @if (Auth::user()->can('xoa-bai-viet'))
                                @if (request()->status != 'trash')
                                <a href="{{ route('post.delete', ['id' => $item->id]) }}" onclick="return confirm('Bán có chắc chắn muốn xóa bản ghi này')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8">
                                <div class="alert alert-primary">Không có bản ghi nào</div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
            {{ $posts->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection