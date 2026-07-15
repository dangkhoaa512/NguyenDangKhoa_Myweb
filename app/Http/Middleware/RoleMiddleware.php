<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Kiểm tra đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()
                ->route('admin.login')
                ->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        // Kiểm tra role của người dùng
        if (!in_array(Auth::user()->role, $roles)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}