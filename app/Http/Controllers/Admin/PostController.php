<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

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
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        return view('admin.posts.create', compact('users'));
    }


public function store(PostRequest $request)
{
    try {
        Post::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Thêm bài viết thành công');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

public function update(PostRequest $request, $id)
{
    try {
        $post = Post::findOrFail($id);

        $post->update([
            'title' => $request->title,
            'slug' => $request->slug,
            'content' => $request->content,
            'user_id' => $request->user_id,
            'status' => $request->status
        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Cập nhật bài viết thành công');

    } catch (\Exception $e) {
        return back()
            ->withInput()
            ->with('error', $e->getMessage());
    }
}

    public function destroy($id) {}
}