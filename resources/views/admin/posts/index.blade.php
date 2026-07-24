@extends('admin.layouts.admin')

@section('title', 'Bài Viết')

@section('content')
    <h2 class="mb-3">DANH SÁCH BÀI VIẾT</h2>

    <x-admin.alert />

    <div class="mb-3 d-flex justify-content-between">
        <a href="{{ route('admin.posts.create') }}" class="btn btn-success">
            + Thêm mới
        </a>
        <a href="{{ route('admin.posts.trash') }}" class="btn btn-outline-danger">
            <i class="bi bi-trash3"></i> Thùng rác
        </a>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>STT</th>
                <th>Ảnh</th>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th>Trạng thái</th>
                <th width="120">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse($list as $item)
                <tr>
                    <td>{{ $list->firstItem() + $loop->index }}</td>
                 <td>
    @php
        $imagePath = 'images/' . ($item->image ?? '');
        $imageUrl = ($item->image && file_exists(public_path($imagePath))) ? asset($imagePath) : asset('images/default.png');
    @endphp
    <img src="{{ $imageUrl }}" width="50" height="50" style="object-fit:cover">
</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->user?->fullname }}</td>
                    <td>
                        @if($item->status)
                            <span class="badge bg-success">Hiện</span>
                        @else
                            <span class="badge bg-danger">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.posts.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        <form action="{{ route('admin.posts.destroy', $item->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Không có dữ liệu</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $list->links() }}
    </div>
@endsection