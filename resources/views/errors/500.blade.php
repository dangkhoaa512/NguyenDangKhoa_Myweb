@extends('errors::layout')
@section('title', __('Lỗi hệ thống'))
@section('code', '500')
@section('message')
    <div class="text-center py-16">
        <div class="text-6xl mb-4">⚠️</div>
        <h1 class="text-3xl font-bold mb-3">500 - Có lỗi xảy ra</h1>
        <p class="text-gray-600 mb-6">Hệ thống đang gặp sự cố, vui lòng thử lại sau.</p>
        <a href="{{ route('admin.home') }}" class="inline-block px-5 py-2 bg-blue-600 text-white rounded">Về trang chủ</a>
    </div>
@endsection