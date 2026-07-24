<footer class="bg-dark text-white mt-5 pt-5 pb-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Mini Shop</h5>
                <p>
                    Mini Shop chuyên cung cấp các sản phẩm công nghệ,
                    phụ kiện máy tính và thiết bị điện tử với chất lượng
                    và giá cả hợp lý.
                </p>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white text-decoration-none">Trang chủ</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white text-decoration-none">Sản phẩm</a></li>
                    <li><a href="{{ route('cart.index') }}" class="text-white text-decoration-none">Giỏ hàng</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Liên hệ</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-4">
                <h5>Liên hệ</h5>
                <p><i class="bi bi-geo-alt"></i> 123 Nguyễn Văn A, TP. Hồ Chí Minh</p>
                <p><i class="bi bi-telephone"></i> 0909 999 999</p>
                <p><i class="bi bi-envelope"></i> support@minishop.com</p>
            </div>
        </div>

        <hr>

        <div class="text-center">
            <small>&copy; {{ date('Y') }} Mini Shop. All Rights Reserved.</small>
        </div>
    </div>
</footer>