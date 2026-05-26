<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return "Danh sách Post";
    }

    public function create()
    {
        return "Form thêm Post";
    }

    public function store(Request $request)
    {
        return "Lưu Post mới";
    }

    public function show($id)
    {
        return "Chi tiết Post ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Post ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Post ID: " . $id;
    }

    public function destroy($id)
    {
        return "Xóa Post ID: " . $id;
    }
}