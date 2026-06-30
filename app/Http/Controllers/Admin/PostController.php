<?php

namespace App\Http\Controllers\Admin;

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

    public function store(Request $request)
    {
        try {
            if (empty($request->user_id)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng chọn tác giả');
            }

            Post::create([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'user_id' => $request->user_id,
                'status' => $request->status ?? 1
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

    public function show($id) {}

    public function edit($id)
    {
        $post = Post::find($id);
        $users = User::select('id', 'fullname')->orderBy('fullname')->get();
        return view('admin.posts.edit', compact('post', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            if (empty($request->user_id)) {
                return back()
                    ->withInput()
                    ->with('error', 'Vui lòng chọn tác giả');
            }

            $post = Post::find($id);

            if (!$post) {
                return redirect()
                    ->route('admin.posts.index')
                    ->with('error', 'Bài viết không tồn tại');
            }

            $post->update([
                'title' => $request->title,
                'slug' => $request->slug,
                'content' => $request->content,
                'user_id' => $request->user_id,
                'status' => $request->status ?? 1
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