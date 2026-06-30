@extends('admin.layouts.admin')

@section('title', 'Thêm Thương Hiệu')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Thêm thương hiệu</h3>

    {{-- Hiển thị tất cả lỗi Validation --}}
<x-admin.alert />

    <form action="{{ route('admin.brands.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên thương hiệu</label>
                    <input type="text" name="brandname" class="form-control" value="{{ old('brandname') }}">
                    @error('brandname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>

                    <input type="radio" class="btn-check" name="status" id="active" value="1"
                        {{ old('status', 1) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">
                        Hiển thị
                    </label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                        {{ old('status') == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">
                        Ẩn
                    </label>

                    @error('status')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection