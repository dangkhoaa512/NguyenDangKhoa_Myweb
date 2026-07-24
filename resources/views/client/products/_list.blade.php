<div class="row">
    @forelse($products as $product)
        <x-client.product-card :product="$product" />
    @empty
        <p class="text-muted">Không tìm thấy sản phẩm nào.</p>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>