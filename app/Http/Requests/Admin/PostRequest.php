<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('post');

        return [
            'title' => [
                'required',
                'string',
                'min:5',
                'max:255',
                Rule::unique('posts', 'title')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('posts', 'slug')->ignore($id, 'id'),
            ],
            'content' => 'required|string|min:10',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'string' => ':attribute phải là chuỗi ký tự.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ, số, dấu gạch dưới (_) và dấu gạch ngang (-).',
            'user_id.required' => 'Vui lòng chọn tác giả.',
            'user_id.exists' => 'Tác giả không tồn tại.',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Tiêu đề',
            'slug' => 'Đường dẫn (Slug)',
            'content' => 'Nội dung',
            'user_id' => 'Tác giả',
            'status' => 'Trạng thái',
        ];
    }
}