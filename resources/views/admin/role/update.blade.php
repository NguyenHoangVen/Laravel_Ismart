@extends('layouts.admin')
@section('title', 'Cập nhật vai trò')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold">
                Cập nhât vai trò
            </div>
            <div class="card-body">
                <form method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Tên vai trò</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ $role->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả vai trò</label>
                            <textarea name="description" class="form-control content" id="description" cols="30"
                                rows="2">{{ $role->description }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>Chọn các quyền</h3>
                                @error('permission_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <input type="checkbox" class="checkall mb-3" value=""> Check ALL
                        @foreach ($groupPermissions as $item)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <input type="checkbox" class="check_parent_group" value="{{ $item->id }}">
                                    {{ $item->name }}
                                </div>
                                <div class="row">
                                    @foreach ($item->permissions as $permission)
                                        <div class="card-body text-dark col-md-3">
                                            <h6 class="card-title">
                                                <input
                                                    {{ $permissionsChecked->contains('id', $permission->id) ? 'checked' : '' }}
                                                    type="checkbox" class="check_child_{{ $item->id }}"
                                                    data-id="{{ $item->id }}" name="permission_id[]"
                                                    value="{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </h6>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/admins/js/role.js') }}"></script>
@endsection
