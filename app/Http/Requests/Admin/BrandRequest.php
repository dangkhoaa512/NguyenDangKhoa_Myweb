<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // lấy giá trị id từ URL hiện tại
        $id = $this->route('brand');

        return [
            'brandname' => [
                'required',
                'min:3',
                'max:100',
                Rule::unique('brands', 'brandname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'min:3',
                'max:150',
                Rule::unique('brands', 'slug')->ignore($id, 'id'),
                'regex:/^[a-z0-9-]+$/',
            ],
            'status' => 'required|in:0,1'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute không được để trống.',
            'min' => ':attribute phải từ :min ký tự trở lên.',
            'max' => ':attribute không vượt quá :max ký tự.',
            'unique' => ':attribute đã tồn tại.',
            'slug.regex' => ':attribute chỉ được chứa chữ thường, số và dấu gạch ngang (-).',
            'status.in' => ':attribute không hợp lệ.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'brandname' => 'Tên thương hiệu',
            'slug' => 'Đường dẫn (Slug)',
            'status' => 'Trạng thái',
        ];
    }
}