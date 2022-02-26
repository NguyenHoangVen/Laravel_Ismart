@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid py-3">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderSuccess }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">ĐƠN HÀNG ĐANG GIAO</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderDelivery }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">ĐƠN HÀNG ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderProcessing }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">DOANH SỐ CỬA HÀNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($revenue, 0, ',', '.') }}Đ</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">ĐƠN HÀNG BỊ HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $orderDelete }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Số lượng trang</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $pages }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">Số lượng bài viết</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $posts }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Số lượng sản phẩm</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $products }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Số lượng User</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $users }}</h5>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Số lượng vai trò</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $roles }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped table-checkall" id="list-product">
                    <thead class="text-center">
                        <tr>
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
                        @php
                            $t = 1;
                        @endphp
                        @foreach ($orders as $item)
                            <tr>
                                <td scope="row">{{ $t++ }}</td>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->customer->name }}</td>
                                <td>{{ $item->orderDetails->sum('quantity') }}</td>
                                <td>{{ number_format($item->total, 0, ',', '.') }}đ</td>
                                @if ($item->status == 0)
                                    <td><span class="badge badge-warning">Đang xử lý</span></td>
                                @endif
                                @if ($item->status == 1)
                                    <td><span class="badge badge-info">Đang giao hàng</span></td>
                                @endif
                                @if ($item->status == 2)
                                    <td><span class="badge badge-success">Hoàn thành</span></td>
                                @endif
                                <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                                <td>
                                    @if (Auth::user()->can('xem-chi-tiet-don-hang'))
                                        <a href="{{ route('order.seen', ['id' => $item->id]) }}"
                                            class="btn btn-info btn-sm" data-toggle="tooltip" title="Chi tiết"><i
                                                class="fas fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>

    </div>
@endsection
