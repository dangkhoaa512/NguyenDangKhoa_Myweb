<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index($limit = 10)
    {
        $list = Post::with('user:id,fullname')
            ->select(
                'id',
                'title',
                'image',
                'status',
                'user_id'
            )
            ->orderBy('title')
            ->paginate($limit);

        return view('admin.posts.index', compact('list'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        Post::create($request->all());
        return redirect()->route('admin.posts.index');
    }

    public function show($id)
    {
        return "Chi tiết Post ID: " . $id;
    }

    public function edit($id)
    {
        return "Form sửa Post ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return "Cập nhật Post ID: " . $id;
    }

    public function destroy($id)
    {
        Post::where('id', $id)->delete();
        return redirect()->route('admin.posts.index');
    }
}