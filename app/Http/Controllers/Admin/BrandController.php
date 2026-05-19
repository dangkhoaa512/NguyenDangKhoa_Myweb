<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return "Danh sách Brand";
    }

    public function create()
    {
        return "Form thêm Brand";
    }

    public function store(Request $request)
    {
        return "Lưu Brand mới";
    }

    public function show($id)
    {
        return "Chi tiết Brand ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Brand ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Brand ID: " . $id;
    }

    public function destroy($id)
    {
        return "Xóa Brand ID: " . $id;
    }
}