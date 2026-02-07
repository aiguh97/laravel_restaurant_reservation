<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableReservation;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'order_id' => 'required|exists:orders,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:reserved,occupied',
        ]);

        $reservation = TableReservation::create($validated);

        return response()->json([
            'success' => true,
            'data' => $reservation
        ], 201);
    }
}
