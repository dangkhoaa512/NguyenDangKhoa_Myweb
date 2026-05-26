<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return "Danh sách Category";
    }

    public function create()
    {
        return "Form thêm Category";
    }

    public function store(Request $request)
    {
        return "Lưu Category mới";
    }

    public function show($id)
    {
        return "Chi tiết Category ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Category ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Category ID: " . $id;
    }

    public function destroy($id)
    {
        return "Xóa Category ID: " . $id;
    }
}