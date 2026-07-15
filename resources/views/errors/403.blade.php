@extends('errors::layout')

@section('title', __('Không có quyền truy cập'))

@section('code', '403')

@section('message')
    <div class="text-center py-16">
        <div class="text-6xl mb-4">🔒</div>
        <h1 class="text-3xl font-bold text-red-600 mb-3">403 - Truy cập bị từ chối</h1>
        <p class="text-gray-600 mb-6">
            {{ $exception->getMessage() ?: 'Bạn không có quyền truy cập chức năng này.' }}
        </p>
        <a href="{{ route('admin.home') }}"
           class="inline-block px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Về trang chủ
        </a>
    </div>
@endsection