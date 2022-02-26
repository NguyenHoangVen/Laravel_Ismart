<div class="sidebar fl-left">
    {{-- categoryProduct --}}
    @include('user.components.categoryProduct')
    {{-- endCategoryProduct --}}
    <div class="section" id="selling-wp">
        <div class="section-head">
            <h3 class="section-title">Sản phẩm bán chạy</h3>
        </div>
        <div class="section-detail">
            <ul class="list-item">
                @foreach ($sellProducts as $item)
                    <li class="clearfix">
                        <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                            title="" class="thumb fl-left">
                            <img class="img-product-sell" src="{{ asset($item->feature_image) }}">
                        </a>
                        <div class="info fl-right">
                            <a href="{{ route('product.detail', ['slugCategory' => $item->category->catProductParent->slug, 'slugProduct' => $item->slug]) }}"
                                title="" class="product-name">{{ $item->name }}</a>
                            <div class="price">
                                <span class="new">{{ number_format($item->price, 0, '', '.') }}đ</span>
                            </div>
                            <a href="{{ route('cart.addProduct', ['id' => $item->id]) }}" title=""
                                class="add-cart buy-now"
                                data-url="{{ route('cart.add', ['id' => $item->id]) }}">Mua ngay</a>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="{{ route('user.index') }}" title="" class="thumb">
                <img src="{{ asset('public/users/images/banner.png') }}" alt="">
            </a>
        </div>
    </div>
</div>
{{-- Modal Add Cart --}}
@include('user.components.modalProductCart')
{{-- End Model Add Cart --}}

{{-- Modal Notitfication --}}
@include('user.components.modalNotification')
{{-- endModal Notitfication --}}
