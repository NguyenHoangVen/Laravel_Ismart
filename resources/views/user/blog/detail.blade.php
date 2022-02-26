@extends('layouts.user')
@section('title', $post->title)
@section('main_class', 'detail-blog-page')
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
        <li>
            <a href="{{ route('user.blog', $catName->slug) }}" title="">{{ $catName->name }}</a>
        </li>
    </ul>
</div>
</div>
<div class="main-content fl-right">
<div class="section" id="detail-blog-wp">
    <div class="section-head clearfix">
        <h3 class="section-title">{{ $post->title }}</h3>
    </div>
    <div class="section-detail">
        <div>
            <span class="author-post">{{ $post->user->name }}</span>
            <span class="create-date">{{ date('d/m/Y', strtotime($post->created_at)) }}</span>
        </div>
        <div class="detail">
            {!! $post->content !!}
        </div>
    </div>
</div>
<div class="section" id="social-wp">
    <div class="section-detail">
        <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small"
            data-show-faces="true" data-share="true"></div>
        <div class="g-plusone-wp">
            <div class="g-plusone" data-size="medium"></div>
        </div>
        <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
    </div>
</div>
</div>
@include('user.components.sidebar')
@endsection
