<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card { width: 100%; max-width: 420px; border-radius: 8px; }
    </style>
</head>
<body>
<div class="card shadow p-4">
    <h4 class="mb-4">Quên mật khẩu</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p class="text-muted">Nhập email đăng ký tài khoản, chúng tôi sẽ gửi link đặt lại mật khẩu.</p>

    <form action="{{ route('admin.forgotpass.post') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" placeholder="Nhập email">
            @error('email')
                <span class="text-danger small">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100">Gửi link đặt lại mật khẩu</button>
    </form>

    <div class="mt-3 text-center">
        <a href="{{ route('admin.login') }}">Quay lại đăng nhập</a>
    </div>
</div>
</body>
</html>