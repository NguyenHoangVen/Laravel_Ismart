@extends('layouts.admin')
@section('title', 'Danh sách các quyền')
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Thêm quyền
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card-body">
                        @if (Auth::user()->can('them-quyen'))
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên quyền</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                        id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Mô tả</label>
                                    <textarea name="description" id="description" cols="35"
                                        rows="5">{{ old('description') }}</textarea>
                                    @error('description')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Chọn nhóm quyền</label>
                                    <select class="form-control" id="" name="group_permission_id">
                                        <option value="">Chọn nhóm quyền</option>
                                        @foreach ($groupPermissions as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('group_permission_id')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Thêm mới</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách các quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Nhóm quyền</th>
                                    <th scope="col">Mô tả</td>
                                    <th scope="col" width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($permissions as $item)
                                    <tr>
                                        <th scope="row">{{ $t++ }}</th>
                                        <td>{{ $item->display_name }}</td>
                                        <td>{{ $item->groupPermission->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            @if (Auth::user()->can('xoa-quyen'))
                                                <a href="{{ route('permission.delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa quyền này!!!')"
                                                    type="button" title="Delete"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $permissions->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
