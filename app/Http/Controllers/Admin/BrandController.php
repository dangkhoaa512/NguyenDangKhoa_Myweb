<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Requests\Admin\BrandRequest;

class BrandController extends Controller
{
    public function index($limit = 10)
    {
        $list = Brand::select('id', 'brandname', 'slug', 'image', 'status')
            ->orderBy('brandname')
            ->paginate($limit);

        return view('admin.brands.index', compact('list'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(BrandRequest $request)
{
    try {
        $imgName = null;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('img')) {
            $imgName = $request->file('img')->store('brands', 'public');
        }

        Brand::create([
            'brandname'   => $request->brandname,
            'slug'        => $request->slug,
            'status'      => $request->status,
            'description' => $request->description,
            'image'       => $imgName,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Thêm thành công.');

    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Thêm thất bại: ' . $e->getMessage());
    }
}

    public function show($id) {}

    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('admin.brands.edit', compact('brand'));
    }

   public function update(BrandRequest $request, string $id)
{
    try {
        $brand = Brand::findOrFail($id);

        $imgName = $brand->image; // giữ ảnh cũ mặc định

        // Nếu người dùng chọn ảnh mới
        if ($request->hasFile('img')) {
            // Xóa ảnh cũ nếu có
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }

            // Upload ảnh mới
            $imgName = $request->file('img')->store('brands', 'public');
        }

        $brand->update([
            'brandname'   => $request->brandname,
            'slug'        => $request->slug,
            'status'      => $request->status,
            'description' => $request->description,
            'image'       => $imgName,
        ]);

        return redirect()
            ->route('admin.brands.index')
            ->with('success', 'Cập nhật thành công.');

    } catch (\Exception $e) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Cập nhật thất bại: ' . $e->getMessage());
    }
}
    public function destroy($id) {}
}