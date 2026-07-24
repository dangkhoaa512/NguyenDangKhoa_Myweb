@props(['product'])

<div class="card h-100 shadow-sm">
    @php
    $imagePath = 'storage/products/' . ($product->image ?? 'default.png');
    $imageUrl = file_exists(public_path($imagePath)) ? asset($imagePath) : asset('images/default.png');
@endphp
<img src="{{ $imageUrl }}"
     class="card-img-top"
     alt="{{ $product->productname }}"
     style="height:150px;object-fit:contain;">

    <div class="card-body d-flex flex-column">
        <h6 class="card-title">{{ $product->productname }}</h6>

        @if ($product->pricediscount > 0)
            <div>
                <span class="text-decoration-line-through text-muted">
                    {{ number_format($product->price) }} đ
                </span>
            </div>
            <h5 class="text-danger fw-bold">
                {{ number_format($product->pricediscount) }} đ
            </h5>
        @else
            <h5 class="text-danger fw-bold">
                {{ number_format($product->price) }} đ
            </h5>
        @endif

        <div class="mt-auto">
            <div class="row g-2">
                <div class="col-6">
                    <a href="{{ route('product.show', ['slug' => $product->slug]) }}" class="btn btn-primary w-100">
                        <i class="bi bi-eye"></i>
                    </a>
                </div>

                <div class="col-6">
                    <button type="button"
                            class="btn btn-success w-100 btn-add-to-cart"
                            data-product-id="{{ $product->id }}">
                        <i class="bi bi-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>