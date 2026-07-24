@extends('client.layouts.app')

@section('title', $product->productname)

@section('content')
    <div class="row g-4">
        <div class="col-md-5">
            <div class="border rounded p-2 mb-3">
                @php
                    $mainImagePath = 'storage/products/' . ($product->image ?? 'default.png');
                    $mainImageUrl = file_exists(public_path($mainImagePath)) ? asset($mainImagePath) : asset('images/default.png');
                @endphp
                <img src="{{ $mainImageUrl }}"
                     class="img-fluid rounded w-100" style="height:400px;object-fit:contain;">
            </div>
            <div class="row g-2">
                @foreach ($product->images as $image)
                    @php
                        $subImagePath = 'storage/products/' . $image->image;
                        $subImageUrl = file_exists(public_path($subImagePath)) ? asset($subImagePath) : asset('images/default.png');
                    @endphp
                    <div class="col-3">
                        <img src="{{ $subImageUrl }}"
                             class="img-fluid rounded border shadow-sm">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-7">
            <h2 class="fw-bold">{{ $product->productname }}</h2>
            <p><strong>Danh mục:</strong> {{ $product->category?->catename }}</p>
            <p><strong>Thương hiệu:</strong> {{ $product->brand?->brandname }}</p>

            @if ($product->pricediscount > 0)
                <h5>
                    <span class="text-decoration-line-through text-secondary me-2">
                        {{ number_format($product->price) }} VNĐ
                    </span>
                    <span class="text-danger fw-bold">
                        {{ number_format($product->pricediscount) }} VNĐ
                    </span>
                </h5>
            @else
                <h4 class="text-danger fw-bold">
                    {{ number_format($product->price) }} VNĐ
                </h4>
            @endif

            <hr>

            <button type="button"
                    class="btn btn-success btn-lg mb-3 btn-add-to-cart"
                    data-product-id="{{ $product->id }}">
                <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
            </button>

            <h5>Mô tả sản phẩm</h5>
            {!! $product->description !!}
        </div>
    </div>

    <hr>

    <h3 class="mb-3">Sản phẩm cùng loại</h3>
    <div class="row">
        @foreach ($relatedProducts as $item)
            <div class="col-md-3 mb-4">
                <x-client.product :product="$item" />
            </div>
        @endforeach
    </div>
@endsection