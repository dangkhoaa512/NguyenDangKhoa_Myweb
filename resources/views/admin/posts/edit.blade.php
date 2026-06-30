@extends('admin.layouts.admin')

@section('title', 'Sửa Bài Viết')

@section('content')
<div class="border rounded bg-white p-4 shadow-sm">
    <h3 class="mb-4">Sửa bài viết</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Tiêu đề</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}">
        </div>
        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}">
        </div>
        <div class="mb-3">
            <label>Tác giả</label>
            <select name="user_id" class="form-select">
                <option value="">-- Chọn tác giả --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $post->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->fullname }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Nội dung</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content', $post->content) }}</textarea>
        </div>
        <div class="mb-3">
            <label class="d-block">Trạng thái</label>
            <input type="radio" name="status" value="1" {{ old('status', $post->status) == 1 ? 'checked' : '' }}> Hiện
            <input type="radio" name="status" value="0" {{ old('status', $post->status) == 0 ? 'checked' : '' }}> Ẩn
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection