@extends('layouts.user')
@section('title', 'Thanh toán đơn hàng')
@section('main_class', 'checkout-page')
@section('css')
    <link rel="stylesheet" href="{{ asset('public/select2/select2.min.css') }}">
@endsection
@section('content')
    <div class="section" id="breadcrumb-wp">
        <div class="section-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{ route('user.index') }}" title="Trang chủ">Trang chủ</a>
                </li>
                <li>
                    <a href="{{ route('user.checkout') }}" title="Thanh toán">Thanh toán</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        <form method="POST" action="{{ route('user.postCheckout') }}" name="form-checkout" id="form-checkout">
            @csrf
            <div class="section" id="customer-info-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin khách hàng</h1>
                </div>
                <div class="section-detail">
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="fullname">Họ tên</label>
                            <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}"
                                placeholder="Nhập họ tên người nhận">
                            @error('fullname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                placeholder="Nhập số điện thoại người nhận">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="email">Email</label>
                            <input type="text" name="email" value="{{ old('email') }}" id="email"
                                placeholder="Nhập email">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row clearfix">
                        <div class="form-col fl-left">
                            <label for="address">Tỉnh/Thành phố</label>
                            <select name="calc_shipping_provinces" id="provinces">
                                <option value="">Tỉnh / Thành phố</option>
                            </select>
                            @error('calc_shipping_provinces')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-col fl-right">
                            <label for="address">Quận/Huyện</label>
                            <select name="calc_shipping_district" id="district">
                                <option value="">Quận / Huyện</option>
                            </select>
                            @error('calc_shipping_district')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <input class="billing_address_1" name="" type="hidden" value="">
                        <input class="billing_address_2" name="" type="hidden" value="">
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label for="address">Địa chỉ</label>
                            <input type="text" name="address" id="address" placeholder="Nhập số nhà, đường, phường ...."
                                value="{{ old('address') }}">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="section" id="order-review-wp">
                <div class="section-head">
                    <h1 class="section-title">Thông tin đơn hàng</h1>
                </div>
                <div class="section-detail">
                    <table class="shop-table">
                        <thead>
                            <tr>
                                <td colspan="3">Sản phẩm</td>
                                <td>Tổng</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($checkoutProducts as $item)
                                <tr class="cart-item">
                                    <td class="product-img" width="22%">
                                        <img src="{{ asset($item->options->image_product) }}" alt="">
                                    </td>
                                    <td class="product-info pl-2">
                                        <p class="product-name">{{ $item->name }}<strong class="product-quantity">x
                                                {{ $item->qty }}</strong>
                                        </p>
                                        <p class="product-price">{{ number_format($item->price, 0, ',', '.') }}đ</p>
                                    </td>
                                    <td class="product-color text-center" width="15%">{{ $item->options->color_name }}
                                    </td>
                                    <td class="product-total">
                                        {{ number_format($item->price * $item->qty, 0, ',', '.') }}đ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="order-total">
                                <td colspan="2">Tổng đơn hàng ( {{ $numProducts }} sản phẩm ) :</td>
                                <td colspan="2">
                                    <strong class="total-price">{{ number_format($totalPrice, 0, ',', '.') }}đ</strong>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    {{-- <div id="payment-checkout-wp">
                    <ul id="payment_methods">
                        <li>
                            <input type="radio" id="direct-payment" name="payment-method" value="direct-payment">
                            <label for="direct-payment">Thanh toán tại cửa hàng</label>
                        </li>
                        <li>
                            <input type="radio" id="payment-home" name="payment-method" value="payment-home">
                            <label for="payment-home">Thanh toán tại nhà</label>
                        </li>
                    </ul>
                </div> --}}
                    <div class="place-order-wp clearfix">
                        <input type="button" id="order-now" name="btn-checkout" value="Đặt hàng">
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/sweetAlert2/sweetalert2@11.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/users/js/cart.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/select2/select2.min.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/gh/vietblogdao/js/districts.min.js'></script>
    <script>
        //<![CDATA[
        if (address_2 = localStorage.getItem('address_2_saved')) {
            $('select[name="calc_shipping_district"] option').each(function() {
                if ($(this).text() == address_2) {
                    $(this).attr('selected', '')
                }
            })

            $('input.billing_address_2').attr('value', address_2)
        }
        if (district = localStorage.getItem('district')) {
            $('select[name="calc_shipping_district"]').html(district)
            $('select[name="calc_shipping_district"]').on('change', function() {
                var target = $(this).children('option:selected')
                target.attr('selected', '')
                $('select[name="calc_shipping_district"] option').not(target).removeAttr('selected')
                address_2 = target.text()
                $('input.billing_address_2').attr('value', address_2)
                district = $('select[name="calc_shipping_district"]').html()
                localStorage.setItem('district', district)
                localStorage.setItem('address_2_saved', address_2)
            })
        }
        $('select[name="calc_shipping_provinces"]').each(function() {
            var $this = $(this),
                stc = ''
            c.forEach(function(i, e) {
                e += +1
                stc += '<option value="' + i + '">' + i + '</option>'
                $this.html('<option value="">Tỉnh / Thành phố</option>' + stc)
                if (address_1 = localStorage.getItem('address_1_saved')) {
                    $('select[name="calc_shipping_provinces"] option').each(function() {
                        if ($(this).text() == address_1) {
                            $(this).attr('selected', '')
                        }
                    })
                    $('input.billing_address_1').attr('value', address_1)
                }
                $this.on('change', function(i) {
                    i = $this.children('option:selected').index() - 1
                    var str = '',
                        r = $this.val()
                    if (r != '') {
                        arr[i].forEach(function(el) {
                            str += '<option value="' + el + '">' + el + '</option>'
                            $('select[name="calc_shipping_district"]').html(
                                '<option value="">Quận / Huyện</option>' + str)
                        })
                        var address_1 = $this.children('option:selected').text()
                        var district = $('select[name="calc_shipping_district"]').html()
                        localStorage.setItem('address_1_saved', address_1)
                        localStorage.setItem('district', district)
                        $('select[name="calc_shipping_district"]').on('change', function() {
                            var target = $(this).children('option:selected')
                            target.attr('selected', '')
                            $('select[name="calc_shipping_district"] option').not(target)
                                .removeAttr('selected')
                            var address_2 = target.text()
                            $('input.billing_address_2').attr('value', address_2)
                            district = $('select[name="calc_shipping_district"]').html()
                            localStorage.setItem('district', district)
                            localStorage.setItem('address_2_saved', address_2)
                        })
                    } else {
                        $('select[name="calc_shipping_district"]').html(
                            '<option value="">Quận / Huyện</option>')
                        district = $('select[name="calc_shipping_district"]').html()
                        localStorage.setItem('district', district)
                        localStorage.removeItem('address_1_saved', address_1)
                    }
                })
            })
        })

        $('#provinces').select2();
        $('#district').select2();

        $('input[name=btn-checkout]').click(function() {
            Swal.fire({
                title: 'Xác nhận đơn hàng',
                text: "Bạn chắc chắn với đơn hàng mình đặt!!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Vâng, xác nhận'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("form#form-checkout").submit()
                }
            })
        })
        //]]>
    </script>
@endsection
