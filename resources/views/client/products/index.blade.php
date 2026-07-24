@extends('client.layouts.app')

@section('title', 'Tất cả sản phẩm')

@section('content')
    <h3 class="mb-4">Tất cả sản phẩm</h3>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <x-client.product :product="$product" />
            </div>
        @empty
            <p class="text-muted">Chưa có sản phẩm nào.</p>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
@endsection