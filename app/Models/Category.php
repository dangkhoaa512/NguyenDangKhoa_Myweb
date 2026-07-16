<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

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