<div class="admin-sidebar bg-dark text-white p-3 vh-100">
    <h4 class="mb-4">
        <i class="bi bi-speedometer2"></i>
        Admin
    </h4>
    <ul class="nav flex-column">

        {{-- Dashboard: tất cả role đã đăng nhập đều thấy --}}
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.home') }}">
                <i class="bi bi-house-door"></i>
                Dashboard
            </a>
        </li>

        {{-- Quản lý danh mục: chỉ Admin (role 1) --}}
        @if(auth()->user()->role == 1)
        <li class="nav-item">
            <a class="nav-link text-white"
               data-bs-toggle="collapse"
               href="#categoryMenu">
                <i class="bi bi-tags"></i>
                Quản lý danh mục
                <i class="bi bi-chevron-down float-end"></i>
            </a>
            <div class="collapse" id="categoryMenu">
                <ul class="nav flex-column ms-3">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.index') }}">
                            Danh sách loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.create') }}">
                            Thêm loại sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('admin.categories.trash') }}">
                            <i class="bi bi-trash3"></i>
                            Thùng rác
                            @php $categoryTrashCount = \App\Models\Category::onlyTrashed()->count(); @endphp
                            @if($categoryTrashCount > 0)
                                <span class="badge bg-danger">{{ $categoryTrashCount }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        {{-- Thương hiệu: chỉ Admin (role 1) --}}
        @if(auth()->user()->role == 1)
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.brands.index') }}">
                <i class="bi bi-patch-check"></i>
                Thương hiệu
            </a>
        </li>
        @endif

        {{-- Người dùng: chỉ Admin (role 1) --}}
        @if(auth()->user()->role == 1)
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i>
                Người dùng
            </a>
        </li>
        @endif

        {{-- Sản phẩm: Admin, Nhân viên, Thu ngân, Kho đều xem được --}}
        @if(in_array(auth()->user()->role, [1, 2, 3, 4]))
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.products.index') }}">
                <i class="bi bi-box-seam"></i>
                Sản phẩm
            </a>
        </li>
        @endif

        {{-- Thùng rác sản phẩm: chỉ Admin (role 1) --}}
        @if(auth()->user()->role == 1)
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.products.trash') }}">
                <i class="bi bi-trash3"></i>
                Thùng rác sản phẩm
                @php $productTrashCount = \App\Models\Product::onlyTrashed()->count(); @endphp
                @if($productTrashCount > 0)
                    <span class="badge bg-danger">{{ $productTrashCount }}</span>
                @endif
            </a>
        </li>
        @endif

        {{-- Bài viết: chỉ Admin (role 1) --}}
        @if(auth()->user()->role == 1)
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.posts.index') }}">
                <i class="bi bi-file-text"></i>
                Bài viết
            </a>
        </li>
        @endif

    </ul>
</div>