@extends('layouts.admin')
@section('title', 'Danh sách trang')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search form-inline">
                <form action="">
                    <input type="text" name="kw" value="{{ request()->input('kw') }}" class="form-control form-search" placeholder="Tìm kiếm">
                    <input type="submit" name="btn_search" value="Tìm kiếm" class="btn btn-primary">
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
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary {{$status == '' ? 'active':''}}">Kích
                    hoạt<span class="text-muted">({{ $count_act }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary {{$status == 'trash' ? 'active':''}}">Vô hiệu
                    hóa<span class="text-muted">({{ $count_trash }})</span></a>
            </div>
            <form action="{{ route('page.action') }}">
                <div class="form-action form-inline py-3">
                    <select class="form-control mr-1" id="" name="act">
                        <option>Chọn</option>
                        @foreach ($list_act as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn_search" value="Áp dụng" class="btn btn-primary">
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">Id</th>
                            <th scope="col">Tiêu đề</th>
                            <th scope="col">Người tạo</th>
                            <th scope="col">Ngày tạo</th>
                            @if (request()->input('status') == 'trash')
                            <th scope="col">Ngày xóa</th>
                            @endif
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($pages->total() > 0)
                        @foreach ($pages as $page)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $page->id }}">
                            </td>
                            <td>{{ $page->id }}</td>
                            <td scope="row">{{ $page->title }}</td>
                            <td>{{ $page->user->name }}</td>
                            <td>{{ date('d/m/Y', strtotime($page->created_at)) }}</td>
                            @if (request()->input('status') == 'trash')
                            <td>{{ $page->deleted_at }}</td>
                            @endif
                            <td>
                                <a href="{{ route('page.update', $page->id) }}" class="btn btn-success btn-sm text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('page.delete', $page->id) }}" onclick="return confirm('Bạn chắc chắn xóa bản ghi này')" class="btn btn-danger btn-sm text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="7">Không có dữ liệu bản ghi</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
            {{ $pages->links() }}
        </div>
    </div>
</div>
@endsection