@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng')
@section('css')
<link rel="stylesheet" href="{{ asset('public/admins/css/detail_order.css') }}">
@endsection
@section('content')
<div id="content" class="container-fluid detail-order">
    <div class="card info-order">
        <div class="card-header font-weight-bold">
            Thông tin đơn hàng
        </div>
        <div class="card-body">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <ul class="list-item">
                <li>
                    <h5 class="title">
                        <i class="fas fa-barcode"></i>
                        Mã đơn hàng
                    </h5>
                    <span class="order-id">{{ $order->id }}</span>
                </li>
                <li>
                    <h5 class="title">
                        <i class="fas fa-clock"></i>
                        Thời gian đặt hàng
                    </h5>
                    <span class="order-time">{{ date('d/m/Y', strtotime($order->created_at)) }}</span>
                </li>
                <li>
                    <h5 class="title">
                        <i class="fas fa-info-circle"></i>
                        Thông tin khách hàng
                    </h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Họ và tên</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->customer->phone }}</td>
                                <td>{{ $order->customer->address }}</td>
                                <td>{{ $order->customer->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                <form method="post">
                    @csrf
                    <li>
                        <h5 class="title">
                            <i class="fas fa-tasks"></i>
                            Tình trạng đơn hàng
                        </h5>
                        <select name="status" id="">
                            @foreach ($selectStatus as $key => $value)
                            <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                {{ $value }}
                            </option>
                            @endforeach
                        </select>
                        <input type="submit" class="btn btn-primary" value="Cập nhật đơn hàng" name="btn-updateOrder">
                        <a href="{{ route('order.cancel', ['id' => $order->id]) }}" onclick="return confirm('Bán có chắc chắn hủy đơn hàng này')" class="btn btn-danger ml-3" data-toggle="tooltip" title="Delete">
                            Hủy đơn hàng</a>
                    </li>
                </form>
            </ul>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Sản phẩm đơn hàng
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" width="13%">Ảnh</th>
                        <th scope="col">Tên sản phâm</th>
                        <th scope="col">Màu</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $t = 1;
                    @endphp
                    @foreach ($orderDetails as $item)
                    <tr>
                        <td scope="row">{{ $t++ }}</td>
                        <td><img class="img-thumbnail" src="{{ asset($item->image_color_path) }}" alt=""></td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->color }}</td>
                        <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Giá trị đơn hàng
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <td class="title-num">Tổng số lượng sản phẩm</td>
                    <td class="detail-num">{{ $order->orderDetails->sum('quantity') }} sản phẩm</td>
                </tr>
                <tr class="total-order">
                    <td class="title-price">Tổng giá trị đơn hàng</td>
                    <td class="detail-price">{{ number_format($order->total, 0, ',', '.') }}đ</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection