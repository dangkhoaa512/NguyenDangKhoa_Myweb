<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Chỉ định tên bảng trong database
    protected $table = 'categories';

    // Chỉ định khóa chính
    protected $primaryKey = 'cateid';

    // Các cột cho phép thêm/sửa dữ liệu hàng loạt
    protected $fillable = [
        'catename',
        'slug',
        'description',
        'image',
        'status'
    ];
}