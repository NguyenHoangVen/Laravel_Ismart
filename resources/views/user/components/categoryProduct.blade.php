<div class="section" id="category-product-wp">
    <div class="section-head">
        <h3 class="section-title">Danh mục sản phẩm</h3>
    </div>
    <div class="secion-detail">
        <ul class="list-item">
            @foreach ($categoryProductParent as $item)
                <li>
                    <a href="{{ route('user.category', $item->slug) }}" title="">{{ $item->name }}</a>
                    @if ($item->catProductChild->count() > 0)
                        @include('user.components.categoryProductChild', ['categoryProductChild' =>
                        $item->catProductChild])
                    @endif
                </li>
            @endforeach


        </ul>
    </div>
</div>
