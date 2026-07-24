<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code',
        'customer_name',
        'phone',
        'email',
        'address',
        'note',
        'total_amount',
        'status',
    ];

    // Bỏ quan hệ customer() vì không có customer_id
    // public function customer()
    // {
    //     return $this->belongsTo(Customer::class, 'customer_id');
    // }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}