{{-- thừa kế layout/view admin.blade.php --}}
@extends('admin.layouts.admin')

@section('title', 'Sửa Sản Phẩm')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Sửa sản phẩm</h3>

    <x-admin.alert />

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input type="text" name="productname" class="form-control"
                           value="{{ old('productname', $product->productname) }}">
                    @error('productname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control"
                           value="{{ old('slug', $product->slug) }}">
                    @error('slug')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Loại sản phẩm</label>
                    <select name="cateid" class="form-select">
                        <option value="">-- Chọn loại sản phẩm --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->cateid }}"
                                {{ old('cateid', $product->cateid) == $category->cateid ? 'selected' : '' }}>
                                {{ $category->catename }}
                            </option>
                        @endforeach
                    </select>
                    @error('cateid')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brandid" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brandid', $product->brandid) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brandname }}
                            </option>
                        @endforeach
                    </select>
                    @error('brandid')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Giá</label>
                    <input type="number" name="price" class="form-control"
                           value="{{ old('price', $product->price) }}">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Giá khuyến mãi</label>
                    <input type="number" name="pricediscount" class="form-control"
                           value="{{ old('pricediscount', $product->pricediscount) }}">
                    @error('pricediscount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label d-block">Trạng thái</label>

                    <input type="radio" class="btn-check" name="status" id="active" value="1"
                        {{ old('status', $product->status) == 1 ? 'checked' : '' }}>
                    <label class="btn btn-outline-success" for="active">Hiển thị</label>

                    <input type="radio" class="btn-check" name="status" id="inactive" value="0"
                        {{ old('status', $product->status) == 0 ? 'checked' : '' }}>
                    <label class="btn btn-outline-danger" for="inactive">Ẩn</label>

                    @error('status')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 img-group">
                    <label class="form-label">Hình ảnh chính</label>
                    <input type="file" name="img" class="form-control img-input">
                    <div class="img-preview mt-2">
                        @if($product->image)
                            <img src="{{ asset('storage/products/' . $product->image) }}"
                                class="img-thumbnail" width="120">
                            <p class="text-muted small">Ảnh hiện tại</p>
                        @endif
                    </div>
                    @error('img')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3 img-group">
                    <label class="form-label">Hình ảnh phụ</label>
                    <input type="file" name="imgs[]" class="form-control img-input" multiple>
                    <div class="img-preview mt-2">
                        @foreach($product->images as $image)
                            <img src="{{ asset('storage/products/' . $image->image) }}"
                                class="img-thumbnail me-2 mb-2" width="100">
                        @endforeach
                    </div>
                    @error('imgs')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection