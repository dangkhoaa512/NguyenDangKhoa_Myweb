@extends('admin.layouts.admin')

@section('title', 'Quản lý đơn hàng')

@section('content')
<h2 class="mb-4">QUẢN LÝ ĐƠN HÀNG</h2>

<x-admin.alert />

{{-- Thống kê --}}
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h5><i class="bi bi-bag"></i> Tổng đơn hàng</h5>
                <p class="fs-3 fw-bold mb-0">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h5><i class="bi bi-cash"></i> Tổng doanh thu</h5>
                <p class="fs-3 fw-bold mb-0">{{ number_format($totalRevenue) }}đ</p>
            </div>
        </div>
    </div>
</div>

{{-- Tìm kiếm --}}
<form action="{{ route('admin.orders.index') }}" method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="keyword" class="form-control"
               placeholder="Tìm mã đơn, tên, SĐT..." value="{{ request('keyword') }}">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">-- Tất cả trạng thái --</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đang giao</option>
            <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Hoàn thành</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đã hủy</option>
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary w-100">Xóa lọc</a>
    </div>
</form>

{{-- Danh sách đơn hàng --}}
<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr>
            <th>STT</th>
            <th>Mã đơn</th>
            <th>Khách hàng</th>
            <th>SĐT</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @forelse($list as $item)
        <tr>
            <td>{{ $list->firstItem() + $loop->index }}</td>
            <td><strong>{{ $item->order_code }}</strong></td>
            <td>{{ $item->customer_name }}</td>
            <td>{{ $item->phone }}</td>
            <td class="text-danger fw-bold">{{ number_format($item->total_amount) }}đ</td>
            <td>
                @if($item->status == 1)
                    <span class="badge bg-warning">Chờ xử lý</span>
                @elseif($item->status == 2)
                    <span class="badge bg-info">Đang giao</span>
                @elseif($item->status == 3)
                    <span class="badge bg-success">Hoàn thành</span>
                @else
                    <span class="badge bg-danger">Đã hủy</span>
                @endif
            </td>
            <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $item->id) }}"
                   class="btn btn-info btn-sm">
                    <i class="bi bi-eye"></i>
                </a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">Không có đơn hàng nào</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $list->appends(request()->query())->links() }}
</div>
@endsection