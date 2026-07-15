@extends('errors::layout')
@section('title', __('Phiên làm việc hết hạn'))
@section('code', '419')
@section('message')
    <div class="text-center py-16">
        <div class="text-6xl mb-4">⏱️</div>
        <h1 class="text-3xl font-bold mb-3">419 - Phiên làm việc đã hết hạn</h1>
        <p class="text-gray-600 mb-6">Vui lòng tải lại trang và thử lại.</p>
        <a href="{{ url()->previous() }}" class="inline-block px-5 py-2 bg-blue-600 text-white rounded">Quay lại</a>
    </div>
@endsection