<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index()
    {
        $list = DB::table('categories')
            ->select('cateid', 'catename', 'slug', 'image', 'status')
            ->where('status', 1)
            ->orderBy('catename')
            ->get();

        return view('admin.categories.index', compact('list'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        DB::table('categories')->insert([
            'catename' => $request->catename,
            'slug' => $request->slug
        ]);

        return redirect()->route('admin.categories.index');
    }

    public function show($id)
    {
        return "Chi tiết Category ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Category ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Category ID: " . $id;
    }

    public function destroy($id)
    {
        DB::table('categories')->where('cateid', $id)->delete();
        return redirect()->route('admin.categories.index');
    }
    
}