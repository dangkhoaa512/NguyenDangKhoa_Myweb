@extends('client.layouts.app')

@section('title', $products->first()?->brandname ?? 'Thương hiệu')

@section('content')
    <h3 class="mb-4">
        Thương hiệu: {{ $products->first()?->brandname }}
    </h3>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <x-client.product :product="$product" />
            </div>
        @empty
            <p class="text-muted">Không có sản phẩm nào thuộc thương hiệu này.</p>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
@endsection