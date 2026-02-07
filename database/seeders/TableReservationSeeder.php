<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TableReservation;

class TableReservationSeeder extends Seeder
{
    public function run(): void
    {
        TableReservation::truncate();

        TableReservation::create([
            'table_id' => 9,
            'date' => now()->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'status' => 'reserved',
        ]);

        TableReservation::create([
            'table_id' => 10,
            'date' => now()->toDateString(),
            'start_time' => '09:30',
            'end_time' => '11:00',
            'status' => 'occupied',
        ]);
    }
}
