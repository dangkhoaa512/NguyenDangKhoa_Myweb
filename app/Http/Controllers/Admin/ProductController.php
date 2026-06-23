<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

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

    public function store(Request $request)
{
    try {
        Product::create([
            'productname'   => $request->productname,
            'slug'          => $request->slug,
            'cateid'        => $request->cateid,
            'brandid'       => $request->brandid,
            'price'         => $request->price,
            'pricediscount' => $request->pricediscount ?? 0,
            'description'   => $request->description,
            'status'        => $request->status,
        ]);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}
    public function show($id) {}
    public function edit($id)
        {
            $product = Product::find($id);
            $categories = Category::select('cateid', 'catename')->orderBy('catename')->get();
            $brands = Brand::select('id', 'brandname')->orderBy('brandname')->get();

            return view('admin.products.edit', compact('product', 'categories', 'brands'));
        }
        public function update(Request $request, string $id)
        {
            try {
        
                // Kiểm tra loại sản phẩm
                if (empty($request->cateid)) {
                    return back()
                        ->withInput()
                        ->with('error', 'Vui lòng chọn loại sản phẩm');
                }
        
                $product = Product::find($id);
        
                if (!$product) {
                    return redirect()
                        ->route('admin.products.index')
                        ->with('error', 'Sản phẩm không tồn tại');
                }
        
                // thực hiện cập nhật sản phẩm
                $product->update([
                    'productname'   => $request->productname,
                    'cateid'        => $request->cateid,
                    'brandid'       => $request->brandid,
                    'price'         => $request->price,
                    'pricediscount' => $request->pricediscount,
                    'status'        => $request->status,
                    'description'   => $request->description
                ]);
        
                return redirect()
                    ->route('admin.products.index')
                    ->with('success', 'Cập nhật sản phẩm thành công');
        
            } catch (\Exception $e) {
        
                return back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }
    public function destroy($id) {}
    public function test1() {}
    public function test2() {}
}