<?php

namespace App\Http\Controllers\Admin;

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
            Brand::create([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Thêm thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Thêm thất bại.');
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

            $brand->update([
                'brandname'   => $request->brandname,
                'slug'        => $request->slug,
                'status'      => $request->status,
                'description' => $request->description,
            ]);

            return redirect()
                ->route('admin.brands.index')
                ->with('success', 'Cập nhật thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Cập nhật thất bại.');
        }
    }

    public function destroy($id) {}
}