@extends('layouts.user')
@section('title', 'Đơn hàng xác nhận thành công')
@section('main_class', 'complete-page')
@section('content')
    <div id="content-complete">
        <img src="{{ asset('public/users/images/thank-you.png') }}" alt="">
        <p class="info">Quý khách đã đặt hàng thành công!</p>
        <p>• Cảm ơn quý khách đã sử dụng sản phẩm của cửa hàng chúng tôi.</p>
        <p>• Nhân viên cửa hàng sẽ liên hệ cho khách hàng trong thời gian sớm nhất để xác nhận đơn hàng của quý khách 1 lần
            nữa.</p>
        <p>• Nhân viên giao hàng sẽ liên hệ với quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng.</p>
        <p>• Địa chỉ cửa hàng: 16/18/21 - Phường TTH - Quận 12 - TP HCM.</p>
        <p>• Số điện thoại cửa hàng: 0364067980</p>
        <p class="text-center return mt-2"><a class="btn btn-outline-primary" title="Quay lại trang chủ"
                href="{{ route('user.index') }}">Quay lại trang chủ</a>
        </p>
    </div>
@endsection
