<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    public function index($limit = 10)
    {
        $list = Category::select('cateid', 'catename', 'slug', 'image', 'status')
            ->orderBy('catename')
            ->paginate($limit);

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'unique:categories,slug',
                    'regex:/^[a-z0-9-]+$/'
                ],
                'status' => 'required|in:0,1',
                'img' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận định dạng jpg, jpeg, png, webp.',
                'img.max' => ':attribute không vượt quá 200KB.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái',
                'img' => 'Hình ảnh',
            ]
        );

        try {
            $imgName = null;

            if ($request->hasFile('img')) {
                $imgName = $request->file('img')->store('categories', 'public');
            }

            Category::create([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status ?? 1,
                'image' => $imgName,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Thêm loại sản phẩm thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show($id) {}

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
                'slug' => [
                    'required',
                    'min:5',
                    'max:150',
                    'regex:/^[a-z0-9-]+$/',
                    Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
                ],
                'status' => 'required|in:0,1',
                'img' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:200',
                ],
            ],
            [
                'required' => ':attribute không được để trống.',
                'min' => ':attribute phải từ :min ký tự trở lên.',
                'max' => ':attribute không vượt quá :max ký tự.',
                'unique' => ':attribute đã tồn tại.',
                'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
                'status.in' => ':attribute không hợp lệ.',
                'img.image' => ':attribute phải là hình ảnh.',
                'img.mimes' => ':attribute chỉ chấp nhận định dạng jpg, jpeg, png, webp.',
                'img.max' => ':attribute không vượt quá 200KB.',
            ],
            [
                'catename' => 'Tên loại',
                'slug' => 'Đường dẫn (Slug)',
                'status' => 'Trạng thái',
                'img' => 'Hình ảnh',
            ]
        );

        try {
            $category = Category::findOrFail($id);

            $imgName = $category->image; // giữ ảnh cũ mặc định

            // Nếu người dùng chọn ảnh mới
            if ($request->hasFile('img')) {
                // Xóa ảnh cũ nếu có
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                // Upload ảnh mới
                $imgName = $request->file('img')->store('categories', 'public');
            }

            $category->update([
                'catename' => $request->catename,
                'slug' => $request->slug,
                'status' => $request->status,
                'image' => $imgName,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Cập nhật thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
        }
    }

    /**
     * Xóa mềm (Soft Delete) — chỉ update cột deleted_at
     */
    public function destroy(string $id)
    {
        try {
            Category::findOrFail($id)->delete();

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Xóa thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Thực hiện thất bại.');
        }
    }

    /**
     * Hiển thị danh sách các danh mục đã bị xóa mềm (Thùng rác)
     */
    public function trash($limit = 10)
    {
        $list = Category::onlyTrashed()
            ->select('cateid', 'catename', 'slug', 'image', 'status', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);

        $trashCount = Category::onlyTrashed()->count();

        return view('admin.categories.trash', compact('list', 'trashCount'));
    }

    /**
     * Khôi phục danh mục từ thùng rác
     */
    public function restore(string $id)
    {
        try {
            Category::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Khôi phục thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    /**
     * Xóa vĩnh viễn khỏi cơ sở dữ liệu
     */
    public function forceDelete(string $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        // Xóa vĩnh viễn vẫn đụng khóa ngoại thật, phải kiểm tra còn sản phẩm không
        $productCount = Product::where('cateid', $id)->count();

        if ($productCount > 0) {
            return redirect()
                ->route('admin.categories.trash')
                ->with('error', "Không thể xóa vĩnh viễn vì vẫn còn {$productCount} sản phẩm thuộc danh mục này.");
        }

        try {
            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->forceDelete();

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', 'Đã xóa vĩnh viễn.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.categories.trash')
                ->with('error', 'Không thể xóa vĩnh viễn do đang được sử dụng ở nơi khác.');
        }
    }
    /**
     * Khôi phục tất cả danh mục trong thùng rác
     */
    public function restoreAll()
    {
        try {
            $count = Category::onlyTrashed()->count();
            Category::onlyTrashed()->restore();

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', "Đã khôi phục {$count} danh mục.");

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Khôi phục thất bại.');
        }
    }

    /**
     * Xóa vĩnh viễn tất cả danh mục trong thùng rác
     * (bỏ qua các danh mục còn sản phẩm liên kết để tránh lỗi khóa ngoại)
     */
    public function forceDeleteAll()
    {
        try {
            $trashedCategories = Category::onlyTrashed()->get();
            $deleted = 0;
            $skipped = 0;

            foreach ($trashedCategories as $category) {
                $productCount = Product::where('cateid', $category->cateid)->count();

                if ($productCount > 0) {
                    $skipped++;
                    continue;
                }

                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                $category->forceDelete();
                $deleted++;
            }

            $message = "Đã xóa vĩnh viễn {$deleted} danh mục.";
            if ($skipped > 0) {
                $message .= " Bỏ qua {$skipped} danh mục vì vẫn còn sản phẩm liên kết.";
            }

            return redirect()
                ->route('admin.categories.trash')
                ->with('success', $message);

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa vĩnh viễn thất bại.');
        }
    }
}