@extends('client.layouts.app')

@section('title', 'Kết quả tìm kiếm')

@section('content')
    <h3 class="mb-2">Kết quả tìm kiếm cho: "{{ $keyword }}"</h3>
    <p class="text-muted mb-4">{{ $products->total() }} sản phẩm được tìm thấy.</p>

    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <x-client.product :product="$product" />
            </div>
        @empty
            <p class="text-muted">Không tìm thấy sản phẩm phù hợp với từ khóa "{{ $keyword }}".</p>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links() }}
    </div>
@endsection