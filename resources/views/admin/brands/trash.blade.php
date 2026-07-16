@extends('admin.layouts.admin')

@section('title', 'Trash - Thương hiệu')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">
            THÙNG RÁC - THƯƠNG HIỆU
            <span class="badge bg-secondary">{{ $trashCount }}</span>
        </h2>
    </div>

    <x-admin.alert />

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.brands.index') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Quay lại danh sách
        </a>

        @if($trashCount > 0)
        <div>
            <form action="{{ route('admin.brands.restoreAll') }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button class="btn btn-success" onclick="return confirm('Khôi phục tất cả {{ $trashCount }} thương hiệu?')">
                    <i class="bi bi-arrow-counterclockwise"></i> Khôi phục tất cả
                </button>
            </form>
            <form action="{{ route('admin.brands.forceDeleteAll') }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn TẤT CẢ thương hiệu trong thùng rác?')">
                    <i class="bi bi-trash3-fill"></i> Xóa vĩnh viễn tất cả
                </button>
            </form>
        </div>
        @endif
    </div>

    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>Ảnh</th>
                <th>Tên thương hiệu</th>
                <th>Slug</th>
                <th>Trạng thái</th>
                <th>Ngày xóa</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" width="50">
                        @endif
                    </td>
                    <td>{{ $item->brandname }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>
                        @if($item->status == 1)
                            <span class="badge bg-success">Hiển thị</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.brands.restore', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success btn-sm">Khôi phục</button>
                        </form>
                        <form action="{{ route('admin.brands.forceDelete', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa vĩnh viễn?')" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Thùng rác trống</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $list->links() }}
</div>
@endsection