<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Danh sách tất cả sản phẩm
     */
    public function index($limit = 12)
    {
        $products = Product::where('status', 1)
            ->select('id', 'productname', 'slug', 'price', 'pricediscount', 'image')
            ->orderByDesc('created_at')
            ->paginate($limit);

        return view('client.products.index', compact('products'));
    }

    /**
     * Chi tiết sản phẩm — truy vấn theo slug
     */
    public function show($slug)
    {
        $product = Product::select(
            'id', 'cateid', 'brandid', 'productname', 'slug',
            'price', 'pricediscount', 'image', 'description'
        )
            ->with([
                'category:cateid,catename',
                'brand:id,brandname',
                'images:id,product_id,image',
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::select('id', 'productname', 'slug', 'price', 'pricediscount', 'image')
            ->where('cateid', $product->cateid)
            ->where('id', '<>', $product->id)
            ->take(4)
            ->get();

        return view('client.products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Lọc theo danh mục
     */
    public function category($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id', 'products.productname', 'products.slug',
            'products.price', 'products.pricediscount', 'products.image',
            'categories.catename'
        )
            ->join('categories', 'products.cateid', 'categories.cateid')
            ->where('categories.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);

        return view('client.products.category', compact('products'));
    }

    /**
     * Lọc theo thương hiệu
     */
    public function brand($slug, $limit = 12)
    {
        $products = Product::select(
            'products.id', 'products.productname', 'products.slug',
            'products.price', 'products.pricediscount', 'products.image',
            'brands.brandname'
        )
            ->join('brands', 'products.brandid', 'brands.id')
            ->where('brands.slug', $slug)
            ->where('products.status', 1)
            ->paginate($limit);

        return view('client.products.brand', compact('products'));
    }

    /**
     * Tìm kiếm — LIKE theo tên sản phẩm
     */
    public function search(Request $request, $limit = 12)
    {
        $keyword = $request->query('q');

        $products = Product::select('id', 'productname', 'slug', 'price', 'pricediscount', 'image')
            ->where('status', 1)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('productname', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->paginate($limit);

        return view('client.products.search', compact('products', 'keyword'));
    }
}