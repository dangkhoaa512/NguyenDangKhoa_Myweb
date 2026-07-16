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
            ->select('id', 'title', 'image', 'status', 'user_id')
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

    /**
     * Xóa mềm (Soft Delete)
     */
    public function destroy($id)
    {
        try {
            Post::findOrFail($id)->delete();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Xóa bài viết thành công.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function trash($limit = 10)
    {
        $list = Post::onlyTrashed()
            ->with('user:id,fullname')
            ->select('id', 'title', 'image', 'status', 'user_id', 'deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->paginate($limit);

        $trashCount = Post::onlyTrashed()->count();

        return view('admin.posts.trash', compact('list', 'trashCount'));
    }

    public function restore($id)
    {
        try {
            Post::onlyTrashed()->findOrFail($id)->restore();

            return redirect()
                ->route('admin.posts.trash')
                ->with('success', 'Khôi phục bài viết thành công.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDelete($id)
    {
        try {
            Post::onlyTrashed()->findOrFail($id)->forceDelete();

            return redirect()
                ->route('admin.posts.trash')
                ->with('success', 'Đã xóa vĩnh viễn.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.posts.trash')
                ->with('error', 'Xóa thất bại.');
        }
    }

    public function restoreAll()
    {
        try {
            $count = Post::onlyTrashed()->count();
            Post::onlyTrashed()->restore();

            return redirect()
                ->route('admin.posts.trash')
                ->with('success', "Đã khôi phục {$count} bài viết.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Khôi phục thất bại.');
        }
    }

    public function forceDeleteAll()
    {
        try {
            $count = Post::onlyTrashed()->count();
            Post::onlyTrashed()->forceDelete();

            return redirect()
                ->route('admin.posts.trash')
                ->with('success', "Đã xóa vĩnh viễn {$count} bài viết.");

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Xóa vĩnh viễn thất bại.');
        }
    }
}