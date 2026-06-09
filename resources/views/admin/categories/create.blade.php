@extends('admin.layouts.admin')

@section('title', 'Thêm Loại Sản Phẩm')

@section('content')
<h2 class="mb-3">THÊM LOẠI SẢN PHẨM</h2>

<form action="{{ route('admin.categories.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Tên loại sản phẩm</label>
        <input type="text" name="catename" class="form-control">
    </div>
    <div class="mb-3">
        <label>Slug</label>
        <input type="text" name="slug" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Lưu</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
</form>
@endsection