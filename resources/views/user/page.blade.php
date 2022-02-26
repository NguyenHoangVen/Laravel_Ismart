@extends('layouts.user')
@section('title', $page->title)
@section('main_class', 'detail-blog-page')
@section('content')
<div class="secion" id="breadcrumb-wp">
<div class="secion-detail">
    <ul class="list-item clearfix">
        <li>
            <a href="{{ route('user.index') }}" title="">Trang chủ</a>
        </li>
        <li>
            <a href="" title="">Blog</a>
        </li>
    </ul>
</div>
</div>
<div class="main-content fl-right">
<div class="section" id="detail-blog-wp">
    <div class="section-head clearfix">
        <h3 class="section-title">{{ $page->title }}</h3>
    </div>
    <div class="section-detail">
        <span class="create-date">{{ date('d/m/Y', strtotime($page->created_at)) }}</span>
        <div class="detail">
            {!! $page->content !!}
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
