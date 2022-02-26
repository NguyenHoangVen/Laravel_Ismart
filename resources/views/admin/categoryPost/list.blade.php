@extends('layouts.admin')
@section('title', 'Danh sách danh mục bài viết')
@section('js')
    <script type="text/javascript" src="{{ asset('public/sweetAlert2/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('public/admins/js/deleteModel.js') }}"></script>
@endsection
@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-4">
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
                        @if (Auth::user()->can('them-danh-muc-bai-viet'))
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Tên danh mục</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                        id="name" value="{{ old('name') }}">
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Danh mục cha</label>
                                    <select class="form-control" id="" name="parent_id">
                                        <option value="0">Danh mục cha</option>
                                        @foreach ($data_select as $key => $val)
                                            <option value="{{ $key }}">{{ $val }}</option>
                                        @endforeach
                                    </select>
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
                        Danh sách danh mục sản phẩm
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">slug</th>
                                    <th scope="col">Danh mục cha</td>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($catPosts as $item)
                                    <tr>
                                        <th scope="row">{{ $t++ }}</th>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->slug }}</td>
                                        @if ($item->parent_id == 0)
                                            <td>None</td>
                                        @else
                                            <td>{{ $item->catPostParent->name }}</td>
                                        @endif
                                        <td>
                                            @if (Auth::user()->can('sua-danh-muc-bai-viet'))
                                                <a href="{{ route('categoryPost.update', ['id' => $item->id]) }}"
                                                    class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i></a>
                                            @endif
                                            @if (Auth::user()->can('xoa-danh-muc-bai-viet'))
                                                <a href=""
                                                    data-url="{{ route('categoryPost.delete', ['id' => $item->id]) }}"
                                                    class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Delete"><i class="fa fa-trash"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    {{-- @include('admin.categoryPost.catPostChild', ['catPostChild' => $item->catPostChild]) --}}
                                @endforeach
                            </tbody>
                        </table>
                        {{ $catPosts->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
