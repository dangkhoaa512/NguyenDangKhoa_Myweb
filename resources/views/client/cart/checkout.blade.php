@extends('client.layouts.app')

@section('title', 'Thanh toán')

@section('content')
<div class="container">
    <h3 class="mb-4">Thanh toán đơn hàng</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <form action="{{ route('cart.placeOrder') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Họ tên người nhận</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email (không bắt buộc)</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Địa chỉ giao hàng</label>
                    <textarea name="address" rows="2" class="form-control">{{ old('address') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ghi chú</label>
                    <textarea name="note" rows="2" class="form-control">{{ old('note') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Đặt hàng</button>
            </form>
        </div>

        <div class="col-md-5">
            <div class="border rounded p-3 bg-light">
                <h5 class="mb-3">Đơn hàng của bạn</h5>
                @php $total = 0; @endphp
                @foreach($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item['proname'] }} x{{ $item['quantity'] }}</span>
                        <span>{{ number_format($subtotal) }}đ</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Tổng cộng</span>
                    <span class="text-danger">{{ number_format($total) }}đ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection