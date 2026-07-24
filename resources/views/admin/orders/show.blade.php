@extends('admin.layouts.admin')

@section('title', 'Chi tiết đơn hàng')

@section('content')
<h2 class="mb-4">CHI TIẾT ĐƠN HÀNG</h2>

<x-admin.alert />

<div class="row">
    {{-- Thông tin khách hàng --}}
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header bg-dark text-white">
                <strong>Thông tin khách hàng</strong>
            </div>
            <div class="card-body">
                <p><strong>Mã đơn:</strong> {{ $order->order_code }}</p>
                <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
                <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                <p><strong>Email:</strong> {{ $order->email ?? 'N/A' }}</p>
                <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                <p><strong>Ghi chú:</strong> {{ $order->note ?? 'Không có' }}</p>
                <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        {{-- Cập nhật trạng thái --}}
        <div class="card">
            <div class="card-header bg-dark text-white">
                <strong>Cập nhật trạng thái</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Đang giao</option>
                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Danh sách sản phẩm --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <strong>Sản phẩm trong đơn</strong>
            </div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>SL</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product_name }}</td>
                            <td>{{ number_format($item->price) }}đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td class="text-danger fw-bold">{{ number_format($item->subtotal) }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Tổng cộng</th>
                            <th class="text-danger">{{ number_format($order->total_amount) }}đ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Quay lại
            </a>
        </div>
    </div>
</div>
@endsection