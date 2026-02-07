<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Table;

class TableController extends Controller
{
    /**
     * Menampilkan daftar semua meja.
     */
public function index(Request $request)
    {
        $date = $request->date ?? now()->toDateString();
        $time = $request->time ?? now()->format('H:i');

        $tables = Table::with(['reservations' => function ($q) use ($date, $time) {
            $q->where('date', $date)
              ->where('start_time', '<=', $time)
              ->where('end_time', '>=', $time)
              ->whereIn('status', ['reserved', 'occupied']);
        }])->get();

        return response()->json(
            $tables->map(function ($table) {
                $reservation = $table->reservations->first();

                return [
                    'id' => $table->id,
                    'name' => $table->name,
                    'capacity' => $table->capacity,
                    'type' => $table->type,
                    'position_x' => $table->position_x,
                    'position_y' => $table->position_y,
                    'is_reserved' => $reservation?->status === 'reserved',
                    'is_occupied' => $reservation?->status === 'occupied',
                ];
            })
        );
    }

    /**
     * Menyimpan meja baru (jika diperlukan fitur tambah meja via API).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'capacity' => 'required|integer',
            'type' => 'required|string',
            'position_x' => 'nullable|integer',
            'position_y' => 'nullable|integer',
        ]);

        $table = Table::create($validated);

        return response()->json([
            'status' => 'success',
            'data' => $table
        ], 201);
    }

    /**
     * Menampilkan detail satu meja.
     */
    public function show($id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        return response()->json($table);
    }

    /**
     * Update posisi atau data meja (Berguna untuk fitur drag-and-drop denah).
     */
    public function update(Request $request, $id)
    {
        $table = Table::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => $table
        ]);
    }
}
