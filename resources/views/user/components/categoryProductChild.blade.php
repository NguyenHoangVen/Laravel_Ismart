<ul class="sub-menu">
    @foreach ($categoryProductChild as $item)
        <li>
            <a href="{{ route('user.category', $item->slug) }}" title="">{{ $item->name }}</a>
            @if ($item->catProductChild->count() > 0)
                @include('user.components.categoryProductChild' , ['categoryProductChild' => $item->catProductChild])
            @endif
        </li>
    @endforeach
</ul>
