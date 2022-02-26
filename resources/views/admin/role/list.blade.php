@extends('layouts.admin')
@section('title', 'Danh sách vai trò')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách vai trò</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="text" class="form-control form-search" name="kw" placeholder="Tìm kiếm tên vai trò"
                            value="{{ request()->kw }}">
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
                <table class="table table-striped table-checkall" id="list-product">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">
                                <input name="checkall" type="checkbox">
                            </th>
                            <th scope="col">#</th>
                            <th scope="col" width="10%">Tên vai trò</th>
                            <th scope="col" width="50%">Các quyền</th>
                            <th scope="col">Miêu tả</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($roles->count() > 0)
                            @php
                                $t = 1;
                            @endphp
                            @foreach ($roles as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $t++ }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        @foreach ($item->permissions as $permission)
                                            <span
                                                class="badge bg-success text-white">{{ $permission->display_name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        @if (Auth::user()->can('sua-vai-tro'))
                                            <a href="{{ route('role.update', ['id' => $item->id]) }}"
                                                class="btn btn-success btn-sm" data-toggle="tooltip"
                                                title="Edit"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if (Auth::user()->can('xoa-vai-tro'))
                                            <a href="{{ route('role.delete', ['id' => $item->id]) }}"
                                                onclick="return confirm('Bán có chắc chắn muốn xóa bản ghi này')"
                                                class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                title="Delete"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Không có bản ghi nào</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                {{ $roles->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection
