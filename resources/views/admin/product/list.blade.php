@extends('layouts.admin')
@section('title', 'Danh sách sản phẩm')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách sản phẩm</h5>
                <div class="form-search form-inline">
                    <form action="">
                        <input type="text" class="form-control form-search" name="kw" placeholder="Tìm kiếm tên sản phẩm"
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
                <div class="analytic">
                    <a href="{{ route('product.list') }}?status=all" class="text-primary {{$status == ''?'active':''}}">Tất cả
                        <span class="text-muted">({{ $count['all'] }})</span></a>
                    <a href="{{ route('product.list') }}?status=public" class="text-primary {{$status == 'public'?'active':''}}">Công
                        khai<span class="text-muted">({{ $count['public'] }})</span></a>
                    <a href="{{ route('product.list') }}?status=pending" class="text-primary {{$status == 'pending'?'active':''}}">Chờ
                        duyệt<span class="text-muted">({{ $count['pending'] }})</span></a>
                    <a href="{{ route('product.list') }}?status=trash" class="text-primary {{$status == 'trash'?'active':''}}">Vô hiệu
                        hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
                </div>
                <form action="{{ route('product.action') }}">
                    <div class="form-action form-inline py-3">
                        @if (Auth::user()->can('sua-san-pham'))
                            <select class="form-control mr-1" id="" name="act">
                                <option value="">Chọn</option>
                                @foreach ($list_act as $key => $val)
                                    <option value="{{ $key }}">{{ $val }}</option>
                                @endforeach
                            </select>
                            <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                        @endif
                    </div>
                    <table class="table table-striped table-checkall" id="list-product">
                        <thead class="text-center">
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                <th scope="col" width="8%">Ảnh</th>
                                <th scope="col" width="23%">Tên sản phẩm</th>
                                <th scope="col">Ảnh chi tiết</th>
                                <th scope="col">Màu</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Nổi bật</th>
                                <th scope="col">Danh mục</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($products->count() > 0)
                                @php
                                    $t = 1;
                                @endphp
                                @foreach ($products as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
                                        <td scope="row">{{ $t++ }}</td>
                                        <td><img class="img-thumbnail" src="{{ asset($item->feature_image) }}" alt="">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('image.list', ['id' => $item->id]) }}"
                                                class="btn btn-outline-info" data-toggle="tooltip" title="Ảnh chi tiết"><i
                                                    class="fas fa-images"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('color.list', ['id' => $item->id]) }}"
                                                class="btn btn-outline-info" data-toggle="tooltip" title="Màu sản phẩm"><i
                                                    class="fas fa-palette"></i></a>
                                        </td>
                                        <td>{{ number_format($item->price, 0, 0, '.') }}</td>
                                        <td>
                                            @if (Auth::user()->can('sua-san-pham'))
                                                <a href="{{ route('product.featured', ['id' => $item->id]) }}"
                                                    class="btn btn-sm {{ $item->featured == 1 ? 'btn-success' : 'btn-secondary' }}"
                                                    onclick="return confirm('Bạn có chắc muốn đổi trạng thái nổi bật!!!')">
                                                    Nổi bật</a>
                                            @else
                                                <a href="javascript:;"
                                                    class="btn btn-sm {{ $item->featured == 1 ? 'btn-success' : 'btn-secondary' }}">
                                                    Nổi bật</a>
                                            @endif
                                        </td>
                                        <td>{{ optional($item->category)->name }}</td>
                                        <td>
                                            @if (Auth::user()->can('sua-san-pham'))
                                                <a href="{{ route('product.update', ['id' => $item->id]) }}"
                                                    class="btn btn-success btn-sm" data-toggle="tooltip"
                                                    title="Edit"><i class="fa fa-edit"></i></a>
                                            @endif
                                            @if (Auth::user()->can('xoa-san-pham'))
                                                @if (request()->status != 'trash')
                                                    <a href="{{ route('product.delete', ['id' => $item->id]) }}"
                                                        onclick="return confirm('Bán có chắc chắn muốn xóa bản ghi này')"
                                                        class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                        title="Delete"><i class="fa fa-trash"></i></a>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="10"><div class="alert alert-primary">Không có bản ghi nào</div></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </form>
                {{ $products->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
@endsection
