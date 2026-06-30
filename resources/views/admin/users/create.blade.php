@extends('admin.layouts.admin')

@section('title', 'Thêm Người Dùng')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Thêm người dùng</h3>

   <x-admin.alert />

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Họ tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}">
                    @error('fullname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                    @error('username')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="d-block">Giới tính</label>
                    <input type="radio" name="gender" value="1" checked> Nam
                    <input type="radio" name="gender" value="2"> Nữ
                    <input type="radio" name="gender" value="0"> Khác
                    @error('gender')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label>Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
                    @error('birthday')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="d-block">Quyền</label>
                    <input type="radio" name="role" value="1" checked> Quản lý
                    <input type="radio" name="role" value="2"> Nhân viên
                    @error('role')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="d-block">Trạng thái</label>
                    <input type="radio" name="status" value="1" checked> Kích hoạt
                    <input type="radio" name="status" value="0"> Khóa
                    @error('status')
                        <span class="text-danger d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection