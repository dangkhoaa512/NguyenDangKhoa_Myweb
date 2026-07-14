<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Http\Requests\Admin\ProductRequest;

class ProductController extends Controller
{
    public function index($limit = 10)
    {
        $list = Product::with([
                'category:cateid,catename',
                'brand:id,brandname'
            ])
            ->select(
                'id',
                'productname',
                'price',
                'image',
                'status',
                'cateid',
                'brandid'
            )
            ->orderBy('productname')
            ->paginate($limit);

        return view('admin.products.index', compact('list'));
    }

    public function create()
    {
        $categories = Category::select('cateid', 'catename')->orderBy('catename')->get();
        $brands = Brand::select('id', 'brandname')->orderBy('brandname')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        try {
            // Upload hình ảnh chính
            $fileName = null;
            if ($request->hasFile('img')) {
                $file = $request->file('img');
                $fileName = Str::slug($request->productname)
                    . '-' . time()
                    . '.' . $file->extension();
                $file->storeAs('products', $fileName, 'public');
            }

            // Lưu sản phẩm
            $product = Product::create([
                'productname'   => $request->productname,
                'slug'          => $request->slug,
                'cateid'        => $request->cateid,
                'brandid'       => $request->brandid,
                'price'         => $request->price,
                'pricediscount' => $request->pricediscount ?? 0,
                'description'   => $request->description,
                'status'        => $request->status,
                'image'         => $fileName,
            ]);

            // Upload hình ảnh phụ
            if ($request->hasFile('imgs')) {
                $i = 1;
                $time = time();
                foreach ($request->file('imgs') as $file) {
                    $imgName = $product->id
                        . '_' . $time . '_' . $i . '.' . $file->extension();
                    $file->storeAs('products', $imgName, 'public');

                    // Lưu vào bảng product_images
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => $imgName,
                    ]);
                    $i++;
                }
            }

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Thêm thành công');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function edit(string $id)
{
    $product = Product::with('images')->findOrFail($id);
    $categories = Category::select('cateid', 'catename')->get();
    $brands = Brand::select('id', 'brandname')->get();

    return view('admin.products.edit', compact('product', 'categories', 'brands'));
}

    public function update(ProductRequest $request, string $id)
{
    try {
        $product = Product::findOrFail($id);

        // Cập nhật ảnh chính nếu có chọn mới
        $fileName = $product->image; // giữ ảnh cũ
        if ($request->hasFile('img')) {
            // Xóa ảnh cũ
            if ($product->image && Storage::disk('public')->exists('products/' . $product->image)) {
                Storage::disk('public')->delete('products/' . $product->image);
            }
            // Upload ảnh mới
            $file = $request->file('img');
            $fileName = Str::slug($request->productname)
                . '-' . time()
                . '.' . $file->extension();
            $file->storeAs('products', $fileName, 'public');
        }

        // Cập nhật sản phẩm
        $product->update([
            'productname'   => $request->productname,
            'slug'          => $request->slug,
            'cateid'        => $request->cateid,
            'brandid'       => $request->brandid,
            'price'         => $request->price,
            'pricediscount' => $request->pricediscount ?? 0,
            'description'   => $request->description,
            'status'        => $request->status,
            'image'         => $fileName,
        ]);

        // Upload thêm ảnh phụ mới (không xóa ảnh phụ cũ)
        if ($request->hasFile('imgs')) {
            $i = 1;
            $time = time();
            foreach ($request->file('imgs') as $file) {
                $imgName = $product->id
                    . '_' . $time . '_' . $i . '.' . $file->extension();
                $file->storeAs('products', $imgName, 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image'      => $imgName,
                ]);
                $i++;
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('admin.products.index');
    }
    public function destroyImage($id)
{
    try {
        $image = ProductImage::findOrFail($id);

        // Xóa file ảnh khỏi storage
        if (Storage::disk('public')->exists('products/' . $image->image)) {
            Storage::disk('public')->delete('products/' . $image->image);
        }

        // Xóa bản ghi trong DB
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa ảnh thành công'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function test1() {}
    public function test2() {}
}