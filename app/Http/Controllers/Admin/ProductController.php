<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return "Danh sách Product";
    }

    public function create()
    {
        return "Form thêm Product";
    }

    public function store(Request $request)
    {
        return "Lưu Product mới";
    }

    public function show($id)
    {
        return "Chi tiết Product ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Product ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Product ID: " . $id;
    }

    public function destroy($id)
    {
        return "Xóa Product ID: " . $id;
    }
}