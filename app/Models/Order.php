<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'transaction_time',
        'total_price',
        'total_item',
        'kasir_id',
        'payment_method',
        'status',
    ];

    public function kasir()
    {
        return $this->belongsTo(User::class, 'kasir_id', 'id');
    }

    public function tableReservation()
{
    // Order memiliki satu reservasi meja
    return $this->hasOne(TableReservation::class, 'order_id');
}

    public function orderItems() {
    return $this->hasMany(OrderItem::class);
}
}
