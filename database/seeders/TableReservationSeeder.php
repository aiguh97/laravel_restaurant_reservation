<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TableReservation;

class TableReservationSeeder extends Seeder
{
    public function run(): void
    {
        TableReservation::create([
            'table_id'   => 9,
            'order_id'   => null, // belum ada order
            'date'       => now()->toDateString(),
            'start_time' => '10:00',
            'end_time'   => '11:00',
            'status'     => 'reserved',
        ]);

        TableReservation::create([
            'table_id'   => 10,
            'order_id'   => 1, // nanti harus ada order id = 1
            'date'       => now()->toDateString(),
            'start_time' => '09:30',
            'end_time'   => '11:00',
            'status'     => 'occupied',
        ]);
    }
}
