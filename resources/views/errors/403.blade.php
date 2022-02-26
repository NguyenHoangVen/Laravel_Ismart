@extends('layouts.admin')
@section('title', 'Lỗi')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0">Bạn không có quyền vào trang này</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img style="max-width: 40%" src="{{ asset('public/admins/img/error-page.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </div>
@endsection
