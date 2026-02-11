<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB untuk transaction

class OrderController extends Controller
{
public function index(Request $request)
{
    $orders = \App\Models\Order::with([
            'orderItems.product',
            'tableReservation.table' // Mengambil reservasi dan detail meja (table_no)
        ])
        ->where('kasir_id', $request->user()->id)
        ->latest()
        ->get();

    // Transformasi data agar table_number muncul di level atas (opsional, agar Flutter lebih mudah baca)
    $orders->transform(function ($order) {
        $order->table_number = $order->tableReservation->table->id ?? 'Take Away';
        return $order;
    });

    return response()->json([
        'success' => true,
        'data' => $orders
    ]);
}

   public function store(Request $request)
{
    $request->validate([
        'transaction_time' => 'required|date',
        'kasir_id' => 'required|exists:users,id',
        'total_price' => 'required|numeric',
        'total_item' => 'required|numeric',
        'payment_method' => 'required|string',
        'order_items' => 'required|array',
        'order_items.*.product_id' => 'required|exists:products,id',
        'order_items.*.quantity' => 'required|numeric|min:1',
        'order_items.*.total_price' => 'required|numeric',
    ]);

    try {
        $order = DB::transaction(function () use ($request) {

            $order = \App\Models\Order::create([
                'transaction_time' => $request->transaction_time,
                'kasir_id' => $request->kasir_id,
                'total_price' => $request->total_price,
                'total_item' => $request->total_item,
                'payment_method' => $request->payment_method,
                'status' => 'pending', // ✅ FIX
            ]);

            foreach ($request->order_items as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['total_price'],
                ]);
            }

            return $order;
        });

        return response()->json([
            'success' => true,
            'message' => 'Order created',
            'data' => [
                'order_id' => $order->id,
                'status' => $order->status,
                'total_price' => $order->total_price,
            ]
        ], 201);

    } catch (\Throwable $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to create order',
            'error' => $e->getMessage(),
        ], 500);
    }
}

// Di Kitchen Controller Laravel
public function kitchenOrders(Request $request)
{
    $orders = \App\Models\Order::with(['orderItems.product'])
        // Tambahkan 'done' di sini agar ditarik semua dari database
        ->whereIn('status', ['pending', 'processing', 'done'])
        ->when(
            $request->status,
            fn ($q) => $q->where('status', $request->status)
        )
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'data' => $orders
    ]);
}
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,processing,done'
    ]);

    $order = \App\Models\Order::findOrFail($id);

    // optional: cegah backward status
    $flow = ['pending' => 1, 'processing' => 2, 'done' => 3];
    if ($flow[$request->status] < $flow[$order->status]) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid status flow'
        ], 422);
    }

    $order->update([
        'status' => $request->status
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Order status updated',
        'data' => $order
    ]);
}


    // public function allOrders()
    // {
    //     try {
    //         // Mengambil semua order dengan relasi item dan produk di dalamnya
    //         $orders = \App\Models\Order::with(['orderItems.product', 'kasir'])
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         if ($orders->isEmpty()) {
    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Belum ada data transaksi',
    //                 'data' => []
    //             ], 200);
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Semua riwayat transaksi berhasil diambil',
    //             'data' => $orders
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengambil data: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
public function allOrders()
{
    $orders = \App\Models\Order::with(['orderItems.product', 'kasir'])
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $orders
    ]);
}


}
