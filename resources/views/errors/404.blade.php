@extends('errors::layout')
@section('title', __('Không tìm thấy trang'))
@section('code', '404')
@section('message')
    <div class="text-center py-16">
        <div class="text-6xl mb-4">🔍</div>
        <h1 class="text-3xl font-bold mb-3">404 - Không tìm thấy</h1>
        <p class="text-gray-600 mb-6">Trang bạn tìm không tồn tại hoặc đã bị xóa.</p>
        <a href="{{ route('admin.home') }}" class="inline-block px-5 py-2 bg-blue-600 text-white rounded">Về trang chủ</a>
    </div>
@endsection