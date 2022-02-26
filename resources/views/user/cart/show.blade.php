@extends('layouts.user')
@section('title', 'Giỏ hàng')
@section('main_class', 'cart-page')
@section('content')
    <div class="section" id="breadcrumb-wp">
        <div class="section-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="{{ route('user.index') }}" title="Trang chủ">Trang chủ</a>
                </li>
                <li>
                    <a href="{{ route('cart.show') }}" title="Giỏ hàng">Giỏ hàng</a>
                </li>
            </ul>
        </div>
    </div>
    <div id="wrapper" class="wp-inner clearfix">
        @if (Cart::count() > 0)
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Màu sản phẩm</th>
                                <th>Giá sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.detail', ['slugCategory' => $item->options->slug_category, 'slugProduct' => $item->options->slug_product]) }}"
                                            title="">
                                            <img class="img-thumbnail" src="{{ asset($item->options->image_product) }}"
                                                alt="">
                                        </a>
                                    </td>
                                    <td class="text-left">
                                        <a href="{{ route('product.detail', ['slugCategory' => $item->options->slug_category, 'slugProduct' => $item->options->slug_product]) }}"
                                            title="" class="name-product">{{ $item->name }}</a>
                                    </td>
                                    <td>{{ $item->options->color_name }}</td>
                                    <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                    <td>
                                        <div class="num-product-wp" data-url="{{ route('cart.update') }}">
                                            <a title="" class="minus {{ $item->qty == 1 ? 'disabled' : '' }}"><i
                                                    class="fa fa-minus"></i></a>
                                            <input type="text" disabled="disabled" name="num-order-cart"
                                                value="{{ $item->qty }}" class="num-order-cart"
                                                data-rowid={{ $item->rowId }}>
                                            <a title="" class="plus"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </td>
                                    <td id="sub-total-{{ $item->rowId }}">
                                        {{ number_format($item->price * $item->qty, 0, ',', '.') }}đ</td>
                                    <td>
                                        <a href="" data-url="{{ route('cart.delete', ['rowId' => $item->rowId]) }}"
                                            data-rowId={{ $item->rowId }}
                                            class="btn btn-danger btn-sm rounded-0 text-white action_delete"
                                            title="Delete"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <p id="total-price" class="fl-right">Tổng giá:
                                            <span class="total-cart">{{ number_format(Cart::total(), 0, ',', '.') }}đ
                                            </span>
                                        </p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="7">
                                    <div class="clearfix">
                                        <div class="fl-right">
                                            <a href="{{ route('user.checkout') }}" title="" id="checkout-cart">Thanh
                                                toán</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <p class="title">Click vào <span>“Cập nhật giỏ hàng”</span> để cập nhật số lượng. Nhập vào số
                        lượng
                        <span>0</span> để xóa sản phẩm khỏi giỏ hàng. Nhấn vào thanh toán để hoàn tất mua hàng.
                    </p>
                    <a href="{{ route('user.index') }}" title="Trang chủ" id="buy-more">Mua tiếp</a><br />
                    <a href="{{ route('cart.delete', ['rowId' => 'all']) }}" title="" id="delete-cart">Xóa giỏ
                        hàng</a>
                </div>
            </div>
        @else
            <div class="not-cart">
                <img src="{{ asset('public/users/images/cart-empty.png') }}" alt="">
                <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
                <a href="{{ route('user.index') }}" class="btn btn-outline-success" title="trang chủ">Quay trở về Trang
                    chủ Ismart Store</a>
            </div>
        @endif
    </div>
@endsection
@section('js')
    <script src="{{ asset('public/sweetAlert2/sweetalert2@11.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/users/js/cart.js') }}" type="text/javascript"></script>

@endsection
