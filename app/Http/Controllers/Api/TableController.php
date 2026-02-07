<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{


public function index(Request $request)
{
    // Ambil tanggal & jam, fallback ke sekarang
    $date = $request->date ?? now()->toDateString();
    $time = $request->time ?? now()->format('H:i');

    $tables = Table::with(['reservations' => function ($q) use ($date) {
        $q->where('date', $date)
          ->whereIn('status', ['reserved', 'occupied']);
    }])->get();

    return response()->json(
        $tables->map(function ($table) use ($time) {
            $is_reserved = $table->reservations->contains(function($r) use ($time) {
                return $r->status === 'reserved'
                    && $r->start_time <= $time
                    && $r->end_time >= $time;
            });

            $is_occupied = $table->reservations->contains(function($r) use ($time) {
                return $r->status === 'occupied'
                    && $r->start_time <= $time
                    && $r->end_time >= $time;
            });

            return [
                'id' => $table->id,
                'name' => $table->name,
                'capacity' => $table->capacity,
                'type' => $table->type,
                'position_x' => $table->position_x,
                'position_y' => $table->position_y,
                'is_reserved' => $is_reserved,
                'is_occupied' => $is_occupied,
            ];
        })
    );
}


}

