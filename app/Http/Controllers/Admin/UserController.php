<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return "Danh sách User";
    }

    public function create()
    {
        return "Form thêm User";
    }

    public function store(Request $request)
    {
        return "Lưu User mới";
    }

    public function show($id)
    {
        return "Chi tiết User ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa User ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật User ID: " . $id;
    }

    public function destroy($id)
    {
        return "Xóa User ID: " . $id;
    }
}