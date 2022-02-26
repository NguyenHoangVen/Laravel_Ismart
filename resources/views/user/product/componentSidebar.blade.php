<div class="sidebar fl-left">
    {{-- categoryProduct --}}
    @include('user.components.categoryProduct')
    {{-- endCategoryProduct --}}
    {{-- filter product --}}
    <div class="section" id="filter-product-wp">
        <div class="section-head">
            <h3 class="section-title">Bộ lọc</h3>
        </div>
        <div class="section-detail">
            <form>
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Hãng</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($catFilter as $item)
                            <tr>
                                <td><input type="checkbox" name="r-brand[]" value="{{ $item->slug }}"
                                        id="{{ $item->id }}" @if (is_array($checkBrand)) {{ in_array($item->slug, $checkBrand) ? 'checked' : '' }} @endif
                                        {{ $item->slug == $catCheck ? 'checked' : '' }} />
                                </td>
                                <td><label for="{{ $item->id }}">{{ $item->name }}</label></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Giá</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" {{ $checkPrice == 'duoi-3-trieu' ? 'checked' : '' }}
                                    name="r-price" value="duoi-3-trieu" id="-3000000"></td>
                            <td><label for="-3000000">Dưới 3.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" {{ $checkPrice == 'tu-3-5-trieu' ? 'checked' : '' }}
                                    name="r-price" value="tu-3-5-trieu" id="500000-1000000"></td>
                            <td><label for="500000-1000000">3.000.000đ - 5.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" {{ $checkPrice == 'tu-5-8-trieu' ? 'checked' : '' }}
                                    name="r-price" value="tu-5-8-trieu" id="1000000-5000000"></td>
                            <td><label for="1000000-5000000">5.000.000đ - 8.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" {{ $checkPrice == 'tu-8-11-trieu' ? 'checked' : '' }}
                                    name="r-price" value="tu-8-11-trieu" id="5000000-10000000">
                            </td>
                            <td><label for="5000000-10000000">8.000.000đ - 11.000.000đ</label></td>
                        </tr>
                        <tr>
                            <td><input type="radio" {{ $checkPrice == 'tren-11-trieu' ? 'checked' : '' }}
                                    name="r-price" value="tren-11-trieu" id="+10000000"></td>
                            <td><label for="+10000000">Trên 11.000.000đ</label></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <input type="submit" class="btn btn-outline-primary" value="Xem kết quả">
                </div>
            </form>
        </div>
    </div>
    {{-- end --}}
    <div class="section" id="banner-wp">
        <div class="section-detail">
            <a href="{{ route('user.index') }}" title="" class="thumb">
                <img src="{{ asset('public/users/images/banner.png') }}" alt="">
            </a>
        </div>
    </div>

</div>
