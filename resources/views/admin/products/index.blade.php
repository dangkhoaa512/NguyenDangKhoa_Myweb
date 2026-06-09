@extends('admin.layouts.admin')

@section('title', 'Sản Phẩm')

@section('content')
<h2 class="mb-3">DANH SÁCH SẢN PHẨM</h2>

<table class="table table-bordered table-hover table-striped">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Loại</th>
            <th>Thương hiệu</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($list as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>
                @if($item->image)
                    <img src="{{ asset('images/' . $item->image) }}" width="50" height="50">
                @else
                    <img src="{{ asset('images/default.png') }}" width="50" height="50">
                @endif
            </td>
            <td>{{ $item->productname }}</td>
            <td>{{ number_format($item->price) }} đ</td>
            <td>{{ $item->catename }}</td>
            <td>{{ $item->brandname }}</td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-success">Hiển thị</span>
                @else
                    <span class="badge bg-danger">Ẩn</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection