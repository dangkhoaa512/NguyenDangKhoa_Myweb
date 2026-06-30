<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'fullname' => 'required|string|min:3|max:100',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:30',
                Rule::unique('users', 'username')->ignore($id, 'id'),
            ],
            'email' => [
                'required',
                'email',
                'max:50',
                Rule::unique('users', 'email')->ignore($id, 'id'),
            ],
            'password' => $id ? 'nullable|min:6' : 'required|min:6',
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($id, 'id'),
            ],
            'address' => 'nullable|string|max:255',
            'gender' => 'required|in:0,1,2',
            'birthday' => 'nullable|date',
            'role' => 'required|in:1,2',
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
            'email' => ':attribute không đúng định dạng.',
            'date' => ':attribute không đúng định dạng ngày tháng.',
            'gender.in' => ':attribute không hợp lệ.',
            'role.in' => ':attribute không hợp lệ.',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    public function attributes(): array
    {
        return [
            'fullname' => 'Họ tên',
            'username' => 'Tên đăng nhập',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'gender' => 'Giới tính',
            'birthday' => 'Ngày sinh',
            'role' => 'Quyền',
            'status' => 'Trạng thái',
        ];
    }
}