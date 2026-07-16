<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $table = 'posts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id'
    ];

    // Quan hệ: 1 post thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}