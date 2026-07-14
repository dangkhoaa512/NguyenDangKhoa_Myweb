@extends('admin.layouts.admin')

@section('title', 'Đổi Mật Khẩu')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="border rounded bg-white p-4 shadow-sm">
            <h3 class="mb-4">Đổi mật khẩu</h3>

            <x-admin.alert />

            {{-- Thông tin người dùng --}}
            <div class="alert alert-info mb-4">
                <i class="bi bi-person-circle"></i>
                Tài khoản: <strong>{{ $user->fullname }}</strong>
                ({{ $user->username }})
            </div>

            <form action="{{ route('admin.change-password.post') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Mật khẩu cũ</label>
                    <input type="password" name="current_password" class="form-control"
                           placeholder="Nhập mật khẩu cũ">
                    @error('current_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="new_password" class="form-control"
                           placeholder="Nhập mật khẩu mới">
                    @error('new_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="new_password_confirmation" class="form-control"
                           placeholder="Nhập lại mật khẩu mới">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-key"></i> Đổi mật khẩu
                </button>
                <a href="{{ route('admin.home') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection