<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    
    <div class="container">

        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            Mini Shop
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Trang chủ</a>
                </li>

                {{-- Dropdown Danh mục --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($categories as $item)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('products.category', ['slug' => $item->slug]) }}">
                                    {{ $item->catename }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- Dropdown Thương hiệu --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown">
                        Thương hiệu
                    </a>
                    <ul class="dropdown-menu">
                        @foreach ($brands as $item)
                            <li>
                                <a class="dropdown-item"
                                   href="{{ route('products.brand', ['slug' => $item->slug]) }}">
                                    {{ $item->brandname }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">Liên hệ</a>
                </li>
            </ul>

            <form class="d-flex me-3" action="{{ route('products.search') }}" method="GET">
                <input class="form-control me-2" type="search" name="q"
                       placeholder="Tìm sản phẩm..." value="{{ request('q') }}">
                <button class="btn btn-outline-primary">Tìm</button>
            </form>

            @php $cartCount = collect(session('cart', []))->sum('quantity'); @endphp
            <a href="{{ route('cart.index') }}" class="btn btn-outline-success">
                <i class="bi bi-cart3"></i>
                Giỏ hàng (<span id="cartCountBadge">{{ $cartCount }}</span>)
            </a>
        </div>
    </div>
</nav>