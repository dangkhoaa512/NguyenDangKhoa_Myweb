@extends('admin.layouts.admin')

@section('title', 'Thương Hiệu')

@section('content')
<h2 class="mb-3">DANH SÁCH THƯƠNG HIỆU</h2>

<x-admin.alert />

<div class="mb-3 d-flex justify-content-between">
    <a href="{{ route('admin.brands.create') }}" class="btn btn-success">
        + Thêm mới
    </a>
    <a href="{{ route('admin.brands.trash') }}" class="btn btn-outline-danger">
        <i class="bi bi-trash3"></i> Thùng rác
    </a>
</div>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>ID</th>
            <th>Tên thương hiệu</th>
            <th>Slug</th>
            <th>Trạng thái</th>
            <th width="120">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $list->firstItem() + $index }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" width="50" height="50">
                @else
                    <img src="{{ asset('images/default.png') }}" width="50" height="50">
                @endif
            </td>
            <td>{{ $item->id }}</td>
            <td>{{ $item->brandname }}</td>
            <td>{{ $item->slug }}</td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
            <td>
                <a href="{{ route('admin.brands.edit', $item->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.brands.destroy', $item->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $list->links() }}
</div>
@endsection