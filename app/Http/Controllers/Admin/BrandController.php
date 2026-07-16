<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
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

            $imgName = $brand->image;

            if ($request->hasFile('img')) {
                if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                    Storage::disk('public')->delete($brand->image);
                }
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

    /**
     * Xóa mềm (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            Brand::findOrFail($id)->delete();

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Xóa thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = Brand::onlyTrashed()
            ->select('id', 'brandname', 'slug', 'image', 'status', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);

        $trashCount = Brand::onlyTrashed()->count();

        return view('admin.brands.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            Brand::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.brands.trash')
                ->with('success', 'Khôi phục thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDelete($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);

        // Brand cũng bị Product tham chiếu qua brandid — kiểm tra trước khi xóa thật
        $productCount = Product::where('brandid', $id)->count();

        if ($productCount > 0) {
            return redirect()
                ->route('admin.brands.trash')
                ->with('error', "Không thể xóa vĩnh viễn vì vẫn còn {$productCount} sản phẩm thuộc thương hiệu này.");
        }

        try {
            if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                Storage::disk('public')->delete($brand->image);
            }

            $brand->forceDelete();

            return redirect()
                ->route('admin.brands.trash')
                ->with('success', 'Đã xóa vĩnh viễn.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.brands.trash')
                ->with('error', 'Không thể xóa vĩnh viễn do đang được sử dụng ở nơi khác.');
        }
    }

    public function restoreAll()
    {
        try {
            $count = Brand::onlyTrashed()->count();
            Brand::onlyTrashed()->restore();

            return redirect()
                ->route('admin.brands.trash')
                ->with('success', "Đã khôi phục {$count} thương hiệu.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $trashedBrands = Brand::onlyTrashed()->get();
            $deleted = 0;
            $skipped = 0;

            foreach ($trashedBrands as $brand) {
                $productCount = Product::where('brandid', $brand->id)->count();

                if ($productCount > 0) {
                    $skipped++;
                    continue;
                }

                if ($brand->image && Storage::disk('public')->exists($brand->image)) {
                    Storage::disk('public')->delete($brand->image);
                }

                $brand->forceDelete();
                $deleted++;
            }

            $message = "Đã xóa vĩnh viễn {$deleted} thương hiệu.";
            if ($skipped > 0) {
                $message .= " Bỏ qua {$skipped} thương hiệu vì vẫn còn sản phẩm liên kết.";
            }

            return redirect()->route('admin.brands.trash')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn thất bại.');
        }
    }
}