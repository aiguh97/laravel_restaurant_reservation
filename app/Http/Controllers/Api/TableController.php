<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;
use Carbon\Carbon;

class TableController extends Controller
{
 public function index(Request $request)
{
    // Gunakan Carbon dengan eksplisit set timezone jika perlu
    $now = \Carbon\Carbon::now('Asia/Jakarta');

    $date = $request->date ?? $now->toDateString();
    $time = $request->time ? \Carbon\Carbon::parse($request->time)->format('H:i:s') : $now->format('H:i:s');

    $tables = \App\Models\Table::with(['reservations' => function ($q) use ($date) {
        $q->where('date', $date)
          ->whereIn('status', ['reserved', 'occupied']);
    }])->get();

    $data = $tables->map(function ($table) use ($time) {
        $activeRes = $table->reservations->first(function($r) use ($time) {
            // Kita bandingkan jam dengan format string yang seragam
            return $time >= $r->start_time && $time <= $r->end_time;
        });

        return [
            'id' => $table->id,
            'name' => $table->name,
            'is_reserved' => $activeRes ? $activeRes->status === 'reserved' : false,
            'is_occupied' => $activeRes ? $activeRes->status === 'occupied' : false,
            // Hapus baris di bawah ini setelah selesai debug:
            'debug_res_count' => $table->reservations->count(),
        ];
    });

    // return response()->json([
    //     'server_time' => $time, // Cek apakah ini benar jam 15:00?
    //     'server_date' => $date,
    //     'tables' => $data
    // ]);
    // MENJADI INI:
return response()->json($data);
}
}
