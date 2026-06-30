@extends('admin.layouts.admin')

@section('title', 'Sửa Loại Sản Phẩm')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Sửa loại sản phẩm</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.categories.update', $category->cateid) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tên loại sản phẩm</label>
            <input type="text" name="catename" class="form-control"
                   value="{{ old('catename', $category->catename) }}">
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control"
                   value="{{ old('slug', $category->slug) }}">
        </div>
        <div class="mb-3">
            <label class="d-block">Trạng thái</label>
            <input type="radio" name="status" value="1" {{ old('status', $category->status) == 1 ? 'checked' : '' }}> Hiển thị
            <input type="radio" name="status" value="0" {{ old('status', $category->status) == 0 ? 'checked' : '' }}> Ẩn
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection