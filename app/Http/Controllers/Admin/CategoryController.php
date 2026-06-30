<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

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
    // Thực hiện Validation dữ liệu
    // Tự động lưu lỗi vào $errors và chuyển về trang trước nếu Validation thất bại
    $request->validate(
        // Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
        [
            'catename' => 'required|min:3|max:100|unique:categories,catename',
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'unique:categories,slug',
                'regex:/^[a-z0-9-]+$/'
            ],
            'status' => 'required|in:0,1'
        ],
        // Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
        [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.'
        ],
        // Param 3: Attributes - tên hiển thị của các trường
        [
            'catename' => 'Tên loại',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái'
        ]
    );

    try {
        Category::create([
            'catename' => $request->catename,
            'slug' => $request->slug,
            'status' => $request->status ?? 1
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

    public function show($id)
    {
        return "Chi tiết Category ID: " . $id;
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
{
    // Validate dữ liệu
    $request->validate(
        // Param 1: Rules - khai báo các quy tắc kiểm tra dữ liệu
        [
            'catename' => 'required|min:3|max:100|unique:categories,catename,' . $id . ',cateid',
            'slug' => [
                'required',
                'min:5',
                'max:150',
                'regex:/^[a-z0-9-]+$/',
                Rule::unique('categories', 'slug')->ignore($id, 'cateid'),
            ],
            'status' => 'required|in:0,1'
        ],

        // Param 2: Messages - tùy chỉnh nội dung thông báo lỗi
        [
            'required'   => ':attribute không được để trống.',
            'min'        => ':attribute phải từ :min ký tự trở lên.',
            'max'        => ':attribute không vượt quá :max ký tự.',
            'unique'     => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in'  => ':attribute không hợp lệ.'
        ],

        // Param 3: Attributes - tên hiển thị của các trường
        [
            'catename' => 'Tên loại',
            'slug'     => 'Đường dẫn (Slug)',
            'status'   => 'Trạng thái'
        ]
    );

    try {
        // Tìm category theo id
        $category = Category::findOrFail($id);

        // Cập nhật dữ liệu
        $category->update([
            'catename'    => $request->catename,
            'slug'        => $request->slug,
            'status'      => $request->status,
            'description' => $request->description,
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

    public function destroy($id)
    {
        DB::table('categories')->where('cateid', $id)->delete();
        return redirect()->route('admin.categories.index');
    }

    
}