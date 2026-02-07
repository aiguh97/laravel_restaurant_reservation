<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::create([
            'transaction_time' => Carbon::now(),
            'total_price'      => 50000,
            'total_item'       => 2,
            'kasir_id'         => 1, // pastikan user id 1 ada
            'payment_method'   => 'cash',
        ]);

        OrderItem::create([
            'order_id'    => $order->id,
            'product_id'  => 1, // pastikan product id 1 ada
            'quantity'    => 1,
            'total_price' => 20000,
        ]);

        OrderItem::create([
            'order_id'    => $order->id,
            'product_id'  => 2, // pastikan product id 2 ada
            'quantity'    => 1,
            'total_price' => 30000,
        ]);
    }
}
