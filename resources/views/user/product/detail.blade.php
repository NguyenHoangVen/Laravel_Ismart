@extends('layouts.user')
@section('title', $product->name)
@section('main_class', 'detail-product-page')
@section('content')
    <div class="secion" id="breadcrumb-wp">
        <div class="secion-detail">
            <ul class="list-item clearfix">
                <li>
                    <a href="" title="">Trang chủ</a>
                </li>
                <li>
                    <a href="{{ route('user.category', $cat->slug) }}" title="">{{ $cat->name }}</a>
                </li>
                <li>
                    <a href="{{ route('user.category', $product->category->slug) }}"
                        title="">{{ $product->category->name }}</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="main-content fl-right">
        <div class="section" id="detail-product-wp">
            <div class="section-detail clearfix">
                <div class="thumb-wp fl-left">
                    <ul id="imageGallery">
                        @foreach ($productColors as $item)
                            <li data-thumb="{{ asset($item->image_color_path) }}"
                                data-src="{{ asset($item->image_color_path) }}">
                                <img class="img-thumbnail img-product" src="{{ asset($item->image_color_path) }}" />
                            </li>
                        @endforeach
                        @foreach ($productImgs as $item)
                            <li data-thumb="{{ asset($item->image_product) }}"
                                data-src="{{ asset($item->image_product) }}">
                                <img class="img-thumbnail img-product" src="{{ asset($item->image_product) }}" />
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="thumb-respon-wp fl-left">
                    <img src="{{ asset('public/users/images/test6.jpg') }}" alt="">
                </div>
                <div class="info fl-right">
                    <h3 class="product-name">{{ $product->name }}</h3>
                    <div class="desc d-flex">
                        @php
                            $t = 1;
                        @endphp
                        @foreach ($productColors as $key => $item)
                            <div class="product-color {{ $key == 0 ? 'active' : '' }}" data-id="{{ $t++ }}">
                                <div class='img img-detail-product'>
                                    <img src="{{ asset($item->image_color_path) }}" alt="">
                                    <input type="radio" {{ $key == 0 ? 'checked' : '' }} name="check-color-detail"
                                        value="{{ $item->id }}" />
                                    <p class="color-name">{{ $item->color->name }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="num-product">
                        <span class="title">Sản phẩm: </span>
                        <span class="status">Còn hàng</span>
                    </div>
                    <p class="price">{{ number_format($product->price, 0, '', '.') }}đ</p>
                    <div id="num-order-detail-wp">
                        <a title="" class="minus"><i class="fa fa-minus"></i></a>
                        <input type="text" name="num-order" value="1" class="num-order" disabled="disabled">
                        <a title="" class="plus"><i class="fa fa-plus"></i></a>
                    </div>
                    <p class="add-cart text-center"><a href="{{ route('cart.add', $product->id) }}" title="Đặt hàng"
                            data-name="{{ $item->name }}">Thêm giỏ hàng</a></p>
                </div>
            </div>
        </div>
        <div class="section" id="post-product-wp">
            <div class="section-head">
                <h3 class="section-title">Mô tả sản phẩm</h3>
            </div>
            <div class="section-detail">
                <div class="product-detail detail-hide">
                    {!! $product->description !!}
                </div>
                <div class="read-more">
                    <a href="#" class="show_hide" data-content="toggle-text">Xem thêm</a>
                </div>
            </div>
        </div>
        <div class="section" id="same-category-wp">
            <div class="section-head">
                <h3 class="section-title">Cùng chuyên mục</h3>
            </div>
            <div class="section-detail">
                <ul class="list-item">
                    @foreach ($sameProduct as $item)
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
                                <a href="?page=checkout" title="Mua ngay" class="buy-now fl-right">Mua
                                    ngay</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @include('user.components.sidebar')
@endsection
@section('js')
    <script src="{{ asset('public/users/js/detail_product.js') }}"></script>
@endsection
