@extends('layouts.user')
@section('title')
    @if (empty($slug))
        Tin mới
    @else
        {{ $catName->name }}
    @endif
@endsection
@section('main_class', 'blog-page')
@section('content')
<div class="secion" id="breadcrumb-wp">
    <div class="secion-detail">
        <ul class="list-item clearfix">
            <li>
                <a href="{{ route('user.index') }}" title="">Trang chủ</a>
            </li>
            <li>
                <a href="{{ route('user.blog') }}" title="">Blog</a>
            </li>
            @if (!empty($slug))
                <li>
                    <a href="{{ route('user.blog', $slug) }}" title="">{{ $catName->name }}</a>
                </li>
            @endif
        </ul>
    </div>
</div>
<div class="main-content fl-right">
    <div class="section" id="list-blog-wp">
        <div class="section-head clearfix">
            <h3 class="section-title">Blog</h3>
        </div>
        <div class="section-menu">
            <ul class="nav nav-tabs">
                @foreach ($catPosts as $key => $item)
                    <li class="nav-item">
                        <a class="nav-link {{ $item['slug'] == $slug ? 'active' : '' }}"
                            href="{{ route('user.blog', ['slug' => $item['slug']]) }}">{{ $item['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="section-detail">
            <ul class="list-item blog-main">
                @foreach ($posts as $item)
                    @php
                        $slugCate = $item->category->slug;
                        $param_url = [
                            'slugCate' => $slugCate,
                            'slugPost' => $item->slug,
                        ];
                    @endphp
                    <li class="clearfix">
                        <a href="{{ route('user.postDetail', $param_url) }}" title="" class="thumb fl-left">
                            <img src="{{ asset($item->image_post) }}" alt="{{ $item->title }}">
                        </a>
                        <div class="info fl-right">
                            <a href="{{ route('user.postDetail', $param_url) }}" title=""
                                class="title">{{ $item->title }}</a>
                            <span class="create-date">{{ date('d/m/Y', strtotime($item->created_at)) }}</span>
                            <p class="desc">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam obcaecati molestias ad maiores voluptas? Harum, at molestiae? Aliquid corrupti tempora itaque id illum architecto sapiente nulla fuga nam odio quae, doloremque labore non vero sunt eligendi? Non, tempora assumenda similique numquam deserunt a earum omnis incidunt autem, optio debitis veniam.</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="section" id="paging-wp">
        <div class="section-detail">
            {{-- <ul class="list-item clearfix">
            <li>
                <a href="" title="">1</a>
            </li>
            <li>
                <a href="" title="">2</a>
            </li>
            <li>
                <a href="" title="">3</a>
            </li>
        </ul> --}}
            @if (!empty($slug))
                {{ $posts->links() }}
            @endif
        </div>
    </div>
</div>
@include('user.components.sidebar')
@endsection
