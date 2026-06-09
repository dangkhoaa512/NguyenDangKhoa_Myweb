<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $list = DB::table('products')
            ->join('categories', 'products.cateid', '=', 'categories.cateid')
            ->leftJoin('brands', 'products.brandid', '=', 'brands.id')
            ->select(
                'products.id',
                'products.productname',
                'products.price',
                'products.image',
                'products.status',
                'categories.catename',
                'brands.brandname'
            )
            ->orderBy('products.productname')
            ->get();

        return view('admin.products.index', compact('list'));
    }

    public function create() {}
    public function store(Request $request) {}
    public function show($id) {}
    public function edit($id) {}
    public function update(Request $request, $id) {}
    public function destroy($id) {}
    public function test1() {}
    public function test2() {}
}