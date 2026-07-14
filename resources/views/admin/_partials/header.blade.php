<div class="ms-auto d-flex align-items-center gap-3">
    @if(Auth::check())
        <span class="text-muted">
            Xin chào, <strong>{{ Auth::user()->fullname }}</strong>
        </span>

        <a href="{{ route('admin.change-password') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-key"></i> Đổi mật khẩu
        </a>

        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-box-arrow-right"></i> Đăng xuất
            </button>
        </form>
    @endif
</div>