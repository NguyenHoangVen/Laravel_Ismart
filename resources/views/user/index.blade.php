@extends('layouts.user')
@section('title', 'Ismart Store')
@section('main_class', 'home-page')
@section('content')
    <div class="main-content fl-right">
        {{-- slider --}}
        @include('user.components.slider')
        {{-- endslider --}}
        <div class="section" id="support-wp">
            <div class="section-detail">
                <ul class="list-item clearfix">
                    <li>
                        <div class="thumb">
                            <img src="public/users/images/icon-1.png">
                        </div>
                        <h3 class="title">Miễn phí vận chuyển</h3>
                        <p class="desc">Tới tận tay khách hàng</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/users/images/icon-2.png">
                        </div>
                        <h3 class="title">Tư vấn 24/7</h3>
                        <p class="desc">1900.9999</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/users/images/icon-3.png">
                        </div>
                        <h3 class="title">Tiết kiệm hơn</h3>
                        <p class="desc">Với nhiều ưu đãi cực lớn</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/users/images/icon-4.png">
                        </div>
                        <h3 class="title">Thanh toán nhanh</h3>
                        <p class="desc">Hỗ trợ nhiều hình thức</p>
                    </li>
                    <li>
                        <div class="thumb">
                            <img src="public/users/images/icon-5.png">
                        </div>
                        <h3 class="title">Đặt hàng online</h3>
                        <p class="desc">Thao tác đơn giản</p>
                    </li>
                </ul>
            </div>
        </div>
        {{-- Sản phẩm nổi bật --}}
        <div class="section" id="feature-product-wp">
            <div class="section-head">
                <h3 class="section-title">Sản phẩm nổi bật</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($products as $item)
                        <li>
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="thumb">
                                <img src="{{ asset($item->feature_image) }}">
                            </a>
                            <a href="?page=detail_product" title="" class="product-name">{{ $item->name }}</a>
                            <div class="price">
                                <span class="new">{{ number_format($item->price, 0, '', '.') }}đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ route('cart.addProduct', ['id' => $item->id]) }}" title=""
                                    class="add-cart fl-left" data-url="{{ route('cart.add', ['id' => $item->id]) }}">Thêm
                                    giỏ hàng</a>
                                <a href="?page=checkout" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {{-- End --}}

        {{-- Điện thoại --}}
        <div class="section" id="list-product-wp">
            <div class="section-head">
                <a href="{{ route('user.category', ['slugCategory' => 'dien-thoai']) }}" class="section-title">Điện
                    thoại</a>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($productIphone as $item)
                        <li>
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="thumb">
                                <img src="{{ asset($item->feature_image) }}">
                            </a>
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="product-name">{{ $item->name }}</a>
                            <div class="price">
                                <span class="new">{{ number_format($item->price, 0, '', '.') }}đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ route('cart.addProduct', ['id' => $item->id]) }}" title="Thêm giỏ hàng"
                                    class="add-cart fl-left" data-url="{{ route('cart.add', ['id' => $item->id]) }}">Thêm
                                    giỏ hàng</a>
                                <a href=" ?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {{-- end --}}

        {{-- Laptop --}}
        <div class="section" id="list-product-wp">
            <div class="section-head">
                <a href="{{ route('user.category', ['slugCategory' => 'laptop']) }}" class="section-title">Laptop</a>
            </div>
            <div class="section-detail">
                <ul class="list-item clearfix">
                    @foreach ($productLaptop as $item)
                        <li class="product-laptop">
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="thumb">
                                <img src="{{ asset($item->feature_image) }}">
                            </a>
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="product-name">{{ $item->name }}</a>
                            <div class="price">
                                <span class="new">{{ number_format($item->price, 0, '', '.') }}đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="{{ route('cart.addProduct', ['id' => $item->id]) }}" title="Thêm giỏ hàng"
                                    class="add-cart fl-left" data-url="{{ route('cart.add', ['id' => $item->id]) }}">Thêm
                                    giỏ hàng</a>
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        {{-- end --}}
    </div>
    @include('user.components.sidebar')


@endsection

