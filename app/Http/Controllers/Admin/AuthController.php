<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.home');
        }
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function postLogin(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required|min:6',
            ],
            [
                'required' => ':attribute không được để trống.',
                'password.min' => 'Mật khẩu phải từ :min ký tự trở lên.',
            ],
            [
                'username' => 'Tên đăng nhập',
                'password' => 'Mật khẩu',
            ]
        );

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()
                ->route('admin.home')
                ->with('success', 'Đăng nhập thành công!');
        }

        return back()
            ->withInput()
            ->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Đăng xuất thành công!');
    }

    // Hiển thị trang đổi mật khẩu
    public function changePassword()
    {
        $user = Auth::user();
        return view('admin.auth.change-password', compact('user'));
    }

    // Xử lý đổi mật khẩu
    public function postChangePassword(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ],
            [
                'required' => ':attribute không được để trống.',
                'new_password.min' => ':attribute phải từ :min ký tự trở lên.',
                'new_password.confirmed' => ':attribute xác nhận không khớp.',
            ],
            [
                'current_password' => 'Mật khẩu cũ',
                'new_password' => 'Mật khẩu mới',
            ]
        );

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()
                ->withInput()
                ->with('error', 'Mật khẩu cũ không đúng.');
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }

    // Hiển thị trang Quên mật khẩu
    public function forgotPassword()
    {
        return view('admin.auth.forgotpassword');
    }

    // Xử lý quên mật khẩu
    public function postForgotPassword(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:users,email'],
            [
                'required' => ':attribute không được để trống.',
                'email' => ':attribute không đúng định dạng.',
                'exists' => ':attribute không tồn tại trong hệ thống.',
            ],
            ['email' => 'Email']
        );

        // Tạo token
        $token = Str::random(64);

        // Xóa token cũ nếu có
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        // Lưu token mới
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Gửi email
        $resetLink = route('admin.reset-password', ['token' => $token])
            . '?email=' . urlencode($request->email);

        Mail::send('admin.auth.email-reset', ['resetLink' => $resetLink], function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Đặt lại mật khẩu');
        });

        return back()->with('success', 'Link đặt lại mật khẩu đã được gửi vào email của bạn!');
    }

    // Hiển thị trang đặt lại mật khẩu
    public function resetPassword(Request $request, $token)
    {
        $email = $request->query('email');

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();

        if (!$record) {
            return redirect()
                ->route('admin.forgotpass')
                ->with('error', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn!');
        }

        return view('admin.auth.reset-password', compact('token', 'email'));
    }

    // Xử lý đặt lại mật khẩu
    public function postResetPassword(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'token' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ],
            [
                'required' => ':attribute không được để trống.',
                'new_password.min' => ':attribute phải từ :min ký tự trở lên.',
                'new_password.confirmed' => ':attribute xác nhận không khớp.',
            ],
            [
                'email' => 'Email',
                'new_password' => 'Mật khẩu mới',
            ]
        );

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->with('error', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn!');
        }

        // Cập nhật mật khẩu mới
        \App\Models\User::where('email', $request->email)
            ->update(['password' => Hash::make($request->new_password)]);

        // Xóa token sau khi dùng
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập lại.');
    }
}