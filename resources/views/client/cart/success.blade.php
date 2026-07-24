@extends('client.layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container text-center py-5">
    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
    <h3 class="mt-3">Đặt hàng thành công!</h3>
    <p class="text-muted">Mã đơn hàng của bạn: <strong>{{ $order->order_code }}</strong></p>

    <div class="border rounded p-4 mt-4 mx-auto text-start" style="max-width: 500px;">
        <p><strong>Người nhận:</strong> {{ $order->customer_name }}</p>
        <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <hr>
        @foreach($order->items as $item)
            <div class="d-flex justify-content-between">
                <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
                <span>{{ number_format($item->subtotal) }}đ</span>
            </div>
        @endforeach
        <hr>
        <div class="d-flex justify-content-between fw-bold">
            <span>Tổng cộng</span>
            <span class="text-danger">{{ number_format($order->total_amount) }}đ</span>
        </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary mt-4">Về trang chủ</a>
</div>
@endsection