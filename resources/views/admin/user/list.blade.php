@extends('layouts.admin')
@section('title', 'Danh sách thành viên')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                <form>
                    <input type="text" class="form-control form-search" name="keyword" value="{{ request()->keyword }}" placeholder="Tìm kiếm">
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
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary {{$status == ''?'active':''}}">Kích
                    hoạt<span class="text-muted">({{ $count[0] }})</span></a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary {{$status == 'trash'?'active':''}}">Vô hiệu
                    hóa<span class="text-muted">({{ $count[1] }})</span></a>
            </div>
            <form action="{{ url('admin/user/action') }}">
                <div class="form-action form-inline py-3">
                    @if (Auth::user()->can('sua-thanh-vien'))
                    <select class="form-control mr-1" name="act" id="">
                        <option>Chọn</option>
                        @foreach ($list_act as $k => $v)
                        <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                    <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    @endif
                </div>
                <table class="table table-striped table-checkall">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" name="checkall">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Quyền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->total() > 0)
                        @php
                        $t = 1;
                        @endphp
                        @foreach ($users as $user)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $user->id }}">
                            </td>
                            <th scope="row">{{ $t++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ optional($user->role)->name }}</td>
                            <td>{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                            <td>
                                @if (Auth::user()->can('sua-thanh-vien'))
                                <a href="{{ route('user.update', $user->id) }}" class="btn btn-success btn-sm text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                                @endif
                                @if (Auth::user()->can('xoa-thanh-vien'))
                                @if (Auth::id() != $user->id && $user->role->name != 'admin')
                                <a href="{{ route('delete_user', $user->id) }}" onclick="return confirm('Bạn chắc chắn xóa bản ghi này')" class="btn btn-danger btn-sm text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <td colspan="7">
                            <div class="alert alert-primary">Không có bản ghi nào</div>
                        </td>
                        @endif

                    </tbody>
                </table>
            </form>
            {{ $users->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection