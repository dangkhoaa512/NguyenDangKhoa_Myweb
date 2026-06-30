@extends('admin.layouts.admin')

@section('title', 'Thêm Người Dùng')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Thêm người dùng</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label>Họ tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}">
                </div>
                <div class="mb-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username') }}">
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label>Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                </div>
                <div class="mb-3">
                    <label class="d-block">Giới tính</label>
                    <input type="radio" name="gender" value="1" checked> Nam
                    <input type="radio" name="gender" value="2"> Nữ
                    <input type="radio" name="gender" value="0"> Khác
                </div>
                <div class="mb-3">
                    <label>Ngày sinh</label>
                    <input type="date" name="birthday" class="form-control" value="{{ old('birthday') }}">
                </div>
                <div class="mb-3">
                    <label class="d-block">Quyền</label>
                    <input type="radio" name="role" value="1" checked> Quản lý
                    <input type="radio" name="role" value="2"> Nhân viên
                </div>
                <div class="mb-3">
                    <label class="d-block">Trạng thái</label>
                    <input type="radio" name="status" value="1" checked> Kích hoạt
                    <input type="radio" name="status" value="0"> Khóa
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection