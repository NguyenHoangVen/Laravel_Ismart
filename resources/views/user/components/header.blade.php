<div id="header-wp">
    <div id="head-top" class="clearfix">
        <div class="wp-inner">
            <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
            <div id="main-menu-wp" class="fl-right">
                <ul id="main-menu" class="clearfix">
                    <li>
                        <a href="{{ route('user.index') }}" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="{{ route('user.blog') }}" title="">Blog</a>
                    </li>
                    @foreach ($pages as $item)
                        <li>
                            <a href="{{ route('user.page', ['id' => $item->id]) }}"
                                title="{{ $item->title }}">{{ $item->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div id="head-body" class="clearfix">
        <div class="wp-inner">
            <a href="{{ route('user.index') }}" title="" id="logo" class="fl-left"><img
                    src="{{ asset('public/users/images/logo.png') }}" /></a>
            <div id="search-wp" class="fl-left">
                <form action="{{ route('user.search') }}" autocomplete="off">
                    <input type="text" name="search" id="search" value="{{ request()->input('search') }}"
                        placeholder="Nhập từ khóa tìm kiếm tại đây!" data-url="{{ route('user.autocomplete') }}">
                    <input type="submit" id="sm-search" value="Tìm kiếm" />
                </form>
                <div id="results-search"></div>
            </div>
            <div id="action-wp" class="fl-right">
                <div id="advisory-wp" class="fl-left">
                    <span class="title">Tư vấn</span>
                    <span class="phone">0987.654.321</span>
                </div>
                <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <span id="num" class="num-total">2</span>
                </a>
                <div id="cart-wp" class="fl-right">
                    <div id="btn-cart">
                        <a href="{{ route('cart.show') }}" title="Giỏ hàng">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                        <span id="num" class="num-total">{{ Cart::count() }}</span>
                    </div>
                    <div id="dropdown-cart-wp">
                        @if (Cart::count() > 0)
                            <div id="dropdown">
                                <p class="desc">Có <span class="num-total">{{ Cart::count() }}</span> sản phẩm trong
                                    giỏ hàng</p>
                                <ul class="list-cart">
                                    @foreach (Cart::content() as $item)
                                        <li class="clearfix">
                                            <a href="{{ route('product.detail', ['slugCategory' => $item->options->slug_category, 'slugProduct' => $item->options->slug_product]) }}"
                                                title="" class="thumb fl-left">
                                                <img src="{{ asset($item->options->image_product) }}" alt="">
                                            </a>
                                            <div class="info fl-right">
                                                <a href="{{ route('product.detail', ['slugCategory' => $item->options->slug_category, 'slugProduct' => $item->options->slug_product]) }}"
                                                    title="" class="product-name">{{ $item->name }}</a>
                                                <p class="price">
                                                    {{ number_format($item->price * $item->qty, 0, ',', '.') }}đ</p>
                                                <div class="color_qty d-flex">
                                                    <p class="color_name mr-3">Màu: <span
                                                            class="font-weight-bold">{{ $item->options->color_name }}</span>
                                                    </p>
                                                    <p class="qty">Số lượng: <span
                                                            class="font-weight-bold">{{ $item->qty }}</span></p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="total-price clearfix">
                                    <p class="title fl-left">Tổng:</p>
                                    <p class="price fl-right text-danger total-cart">
                                        {{ number_format(Cart::total(), 0, ',', '.') }}đ</p>
                                </div>
                                <div class="action-cart clearfix">
                                    <a href="{{ route('cart.show') }}" title="Giỏ hàng" class="view-cart fl-left">Giỏ
                                        hàng</a>
                                    <a href="{{ route('user.checkout') }}" title="Thanh toán"
                                        class="checkout fl-right">Thanh toán</a>
                                </div>
                            </div>
                        @else
                            <div id="cart-empty">
                                <p class="desc">Không có sản phẩm trong giỏ hàng</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
