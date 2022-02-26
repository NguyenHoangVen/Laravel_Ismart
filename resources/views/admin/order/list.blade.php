@extends('layouts.admin')
@section('title', 'Danh sách đơn hàng')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline">
                <form action="">
                    <input type="text" class="form-control form-search" name="kw" placeholder="Tìm kiếm tên sản phẩm" value="{{ request()->kw }}">
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
                <a href="{{ route('order.index') }}?status=all" class="text-primary {{$status == '' ? 'active':''}}">Tất cả
                    <span class="text-muted">({{ $count['all'] }})</span></a>
                <a href="{{ route('order.index') }}?status=processing" class="text-primary {{$status == 'processing' ? 'active':''}}">Đang xử lý<span class="text-muted">({{ $count['processing'] }})</span></a>
                <a href="{{ route('order.index') }}?status=delivery" class="text-primary {{$status == 'delivery' ? 'active':''}}">Đang giao<span class="text-muted">({{ $count['delivery'] }})</span></a>
                <a href="{{ route('order.index') }}?status=complete" class="text-primary {{$status == 'complete' ? 'active':''}}">Hoàn thành<span class="text-muted">({{ $count['complete'] }})</span></a>
                <a href="{{ route('order.index') }}?status=cancel" class="text-primary {{$status == 'cancel' ? 'active':''}}">Hủy đơn
                    hóa<span class="text-muted">({{ $count['cancel'] }})</span></a>
            </div>
            <form action="{{ route('order.action') }}">
                <div class="form-action form-inline py-3">
                    @if (Auth::user()->can('cap-nhat-don-hang'))
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
                            <th scope="col">STT</th>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Họ và tên</th>
                            <th scope="col">Số sản phẩm</th>
                            <th scope="col">Tổng giá</th>
                            <th scope="col">Trang thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @if ($orders->count() > 0)
                        @php
                        $t = 1;
                        @endphp
                        @foreach ($orders as $item)
                        <tr>
                            <td>
                                <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                            </td>
                            <td scope="row">{{ $t++ }}</td>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->customer->name }}</td>
                            <td>{{ $item->orderDetails->sum('quantity') }}</td>
                            <td>{{ number_format($item->total, 0, ',', '.') }}đ</td>
                            @if ($item->status == 0)
                            <td>
                                <span class="badge badge-warning">
                                    Đang xử lý</span>
                            </td>
                            @endif
                            @if ($item->status == 1)
                            <td><span class="badge badge-info">Đang
                                    giao hàng</span></td>
                            @endif
                            @if ($item->status == 2)
                            <td><span class="badge badge-success">Hoàn
                                    thành</span></td>
                            @endif
                            @if ($item->status == 3)
                            <td><span class="badge badge-danger">Đã hủy
                                </span></td>
                            @endif
                            <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td>
                                @if (Auth::user()->can('xem-chi-tiet-don-hang'))
                                <a href="{{ route('order.seen', ['id' => $item->id]) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Seen"><i class="fas fa-eye"></i></a>
                                @endif
                                @if (Auth::user()->can('huy-don-hang'))
                                @if (request()->status != 'cancel')
                                <a href="{{ route('order.cancel', ['id' => $item->id]) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này')" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="9">Không có bản ghi nào</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </form>
            {{ $orders->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection