<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table; // 1. Pastikan model Table di-import
use Illuminate\Support\Facades\DB;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        // 2. Gunakan DB::table jika ingin menghindari masalah mass assignment saat truncate
        // Atau tetap gunakan Table::truncate() jika $fillable sudah aman.
        Table::truncate();

        $tables = [
            // ===== MAIN TABLE =====
            [
                'name' => 'Main Table',
                'capacity' => 8,
                'type' => 'main',
                'position_x' => 50,
                'position_y' => 50,
            ],

            // ===== 4 SEAT TABLES (TOP) =====
            ['name' => 'Table - 1', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 10, 'position_y' => 10],
            ['name' => 'Table - 2', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 40, 'position_y' => 10],
            ['name' => 'Table - 3', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 70, 'position_y' => 10],

            // ===== 4 SEAT TABLES (MIDDLE) =====
            ['name' => 'Table - 4', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 10, 'position_y' => 40],
            ['name' => 'Table - 5', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 70, 'position_y' => 40],

            // ===== 4 SEAT TABLES (BOTTOM) =====
            ['name' => 'Table - 6', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 10, 'position_y' => 70],
            ['name' => 'Table - 7', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 70, 'position_y' => 70],
            ['name' => 'Table - 8', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 10, 'position_y' => 90],
            ['name' => 'Table - 9', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 40, 'position_y' => 90],
            ['name' => 'Table - 10', 'capacity' => 4, 'type' => '4-seat', 'position_x' => 70, 'position_y' => 90],

            // ===== 2 SEAT TABLES =====
            ['name' => 'Table - 11', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 10, 'position_y' => 120],
            ['name' => 'Table - 12', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 40, 'position_y' => 120],
            ['name' => 'Table - 13', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 70, 'position_y' => 120],
            ['name' => 'Table - 14', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 10, 'position_y' => 140],
            ['name' => 'Table - 15', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 40, 'position_y' => 140],
            ['name' => 'Table - 16', 'capacity' => 2, 'type' => '2-seat', 'position_x' => 70, 'position_y' => 140],
        ];

        // 3. Gunakan insert() untuk performa lebih cepat (satu query untuk semua data)
        // Namun, insert() tidak akan otomatis mengisi timestamp (created_at/updated_at).
        // Jika butuh timestamp, gunakan loop Table::create() atau tambahkan manual di array.
        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
