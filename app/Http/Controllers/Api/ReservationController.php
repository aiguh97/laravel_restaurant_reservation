<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TableReservation;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use App\Events\TableStatusChanged; // Sudah benar diimport

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'order_id' => 'required|exists:orders,id',
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required',
            'end_time' => 'required',
            'status' => 'required|in:reserved,occupied',
            'customer_name' => 'nullable|string',
        ]);

        try {
            // 2. Cek apakah meja sudah dipesan (Overlap)
            $isBooked = TableReservation::where('table_id', $validated['table_id'])
                ->where('date', $validated['date'])
                ->where(function ($query) use ($validated) {
                    $query->where('start_time', '<', $validated['end_time'])
                          ->where('end_time', '>', $validated['start_time']);
                })
                ->exists();

            if ($isBooked) {
                return response()->json([
                    'success' => false,
                    'message' => 'Meja sudah dipesan atau sedang digunakan pada jam tersebut.'
                ], 422);
            }

            // 3. Simpan data & Broadcast Event
            $reservation = DB::transaction(function () use ($validated) {
                $created = TableReservation::create($validated);

                // 🔥 MODIFIKASI DISINI: Memicu Event Real-time
                // broadcast() akan mengirim data ke Reverb/Redis agar diteruskan ke Flutter
                broadcast(new TableStatusChanged($validated['table_id'], $validated['status']))->toOthers();

                return $created;
            });

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibuat',
                'data' => $reservation
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }
}
