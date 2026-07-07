<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product');

        return [
            'productname' => [
                'required',
                'string',
                'min:5',
                'max:150',
                Rule::unique('products', 'productname')->ignore($id, 'id'),
            ],
            'slug' => [
                'required',
                'string',
                'min:5',
                'max:200',
                'regex:/^[a-zA-Z0-9_-]+$/',
                Rule::unique('products', 'slug')->ignore($id, 'id'),
            ],
            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999.99',
            ],
            'pricediscount' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:price',
            ],
            'status' => 'required|in:0,1',
            'cateid' => 'required|exists:categories,cateid',
            'brandid' => 'required|exists:brands,id',
            'description' => [
                'nullable',
                'regex:/^[^@!$^]*$/',
            ],
            'img' => [
                $this->isMethod('POST') ? 'required' : 'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
            'imgs' => [
                'nullable',
                'array',
            ],
            'imgs.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:200',
            ],
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
            'numeric' => ':attribute phải là số.',
            'slug.regex' => ':attribute chỉ được chứa chữ, số, dấu gạch dưới (_) và dấu gạch ngang (-).',
            'description.regex' => ':attribute không được chứa các ký tự đặc biệt như @, !, $, ^.',
            'price.max' => ':attribute không được vượt quá 10.000.000.',
            'pricediscount.lte' => ':attribute không được lớn hơn giá gốc.',
            'status.in' => ':attribute không hợp lệ.',
            'cateid.required' => 'Vui lòng chọn loại sản phẩm.',
            'cateid.exists' => 'Loại sản phẩm không tồn tại.',
            'brandid.required' => 'Vui lòng chọn thương hiệu.',
            'brandid.exists' => 'Thương hiệu không tồn tại.',
            'image' => ':attribute phải là hình ảnh.',
            'mimes' => ':attribute chỉ chấp nhận các định dạng: jpg, jpeg, png, webp.',
            'img.max' => ':attribute không được vượt quá 200 KB.',
            'imgs.*.max' => ':attribute không được vượt quá 200 KB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'productname' => 'Tên sản phẩm',
            'slug' => 'Đường dẫn (Slug)',
            'price' => 'Giá',
            'pricediscount' => 'Giá khuyến mãi',
            'status' => 'Trạng thái',
            'cateid' => 'Loại sản phẩm',
            'brandid' => 'Thương hiệu',
            'description' => 'Mô tả',
            'img' => 'Hình ảnh chính',
            'imgs' => 'Hình ảnh phụ',
            'imgs.*' => 'Hình ảnh phụ',
        ];
    }
}