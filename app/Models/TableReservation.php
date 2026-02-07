<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    protected $fillable = [
        'table_id',
           'order_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

   public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

        public function order()
    {
        return $this->belongsTo(Order::class);
    }

}
