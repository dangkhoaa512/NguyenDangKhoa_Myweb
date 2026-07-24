@extends('client.layouts.app')

@section('title', 'Giỏ hàng')

@section('content')
<div class="container">
    <h3 class="mb-4">Giỏ hàng của bạn</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart))
        <p class="text-muted">Giỏ hàng đang trống.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @else
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Đơn giá</th>
                    <th width="150">Số lượng</th>
                    <th>Thành tiền</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach($cart as $id => $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <tr>
                        <td class="d-flex align-items-center gap-2">
                            @php
    $imagePath = 'storage/products/' . ($item['image'] ?? '');
    $imageUrl = (!empty($item['image']) && file_exists(public_path($imagePath))) ? asset($imagePath) : asset('images/default.png');
@endphp
<img src="{{ $imageUrl }}" width="60" class="rounded" style="height:60px;object-fit:contain;">
                            <span>{{ $item['proname'] }}</span>
                        </td>
                        <td>{{ number_format($item['price']) }}đ</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="qty" value="{{ $item['quantity'] }}" min="1"
                                       class="form-control form-control-sm" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-outline-secondary ms-1">
                                    <i class="bi bi-arrow-repeat"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ number_format($subtotal) }}đ</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa sản phẩm này khỏi giỏ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Tiếp tục mua sắm</a>
            <div class="text-end">
                <h5>Tổng cộng: <span class="text-danger">{{ number_format($total) }}đ</span></h5>
                <a href="{{ route('cart.checkout') }}" class="btn btn-primary btn-lg">Tiến hành thanh toán</a>
            </div>
        </div>
    @endif
</div>
@endsection