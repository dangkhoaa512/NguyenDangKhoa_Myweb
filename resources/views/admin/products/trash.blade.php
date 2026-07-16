@extends('admin.layouts.admin')

@section('title', 'Thùng rác sản phẩm')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">
            Thùng rác sản phẩm
            <span class="badge bg-secondary">{{ $trashCount }}</span>
        </h3>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
    </div>

    <x-admin.alert />

    @if($trashCount > 0)
    <div class="mb-3">
        <form action="{{ route('admin.products.restoreAll') }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success"
                onclick="return confirm('Khôi phục tất cả {{ $trashCount }} sản phẩm?')">
                <i class="bi bi-arrow-counterclockwise"></i> Khôi phục tất cả
            </button>
        </form>
        <form action="{{ route('admin.products.forceDeleteAll') }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger"
                onclick="return confirm('Xóa VĨNH VIỄN tất cả {{ $trashCount }} sản phẩm trong thùng rác? Không thể hoàn tác!')">
                <i class="bi bi-trash3-fill"></i> Xóa vĩnh viễn tất cả
            </button>
        </form>
    </div>
    @endif

    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Hình ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Ngày xóa</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $product)
            <tr>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/products/' . $product->image) }}" width="60">
                    @endif
                </td>
                <td>{{ $product->productname }}</td>
                <td>{{ number_format($product->price) }}đ</td>
                <td>{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                <td class="text-center">
                    <form action="{{ route('admin.products.restore', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success btn-sm"
                            onclick="return confirm('Khôi phục sản phẩm này?')">
                            <i class="bi bi-arrow-counterclockwise"></i> Khôi phục
                        </button>
                    </form>
                    <form action="{{ route('admin.products.force-delete', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Xóa VĨNH VIỄN sản phẩm này? Không thể hoàn tác!')">
                            <i class="bi bi-trash3-fill"></i> Xóa vĩnh viễn
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center">Thùng rác trống</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $list->links() }}
</div>
@endsection