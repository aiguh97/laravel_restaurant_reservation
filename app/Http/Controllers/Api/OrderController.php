<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB untuk transaction

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'transaction_time' => 'required',
            'kasir_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric',
            'total_item' => 'required|numeric',
            'order_items' => 'required|array',
            'order_items.*.product_id' => 'required|exists:products,id',
            'order_items.*.quantity' => 'required|numeric',
            'order_items.*.total_price' => 'required|numeric',
        ]);

        try {
            // 2. Gunakan Transaction agar data konsisten (jika satu gagal, semua batal)
            $order = DB::transaction(function () use ($request) {

                // Create Order utama
                $order = \App\Models\Order::create([
                    'transaction_time' => $request->transaction_time,
                    'kasir_id' => $request->kasir_id,
                    'total_price' => $request->total_price,
                    'total_item' => $request->total_item,
                    'payment_method' => $request->payment_method,
                ]);

                // Create Order Items
                foreach ($request->order_items as $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id, // Mengambil ID dari order yang baru dibuat
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'total_price' => $item['total_price'],
                    ]);
                }

                return $order;
            });

            // 3. Response dengan mengembalikan id
            return response()->json([
                'success' => true,
                'message' => 'Order Created Successfully',
                'order_id' => $order->id, // Mengembalikan ID pesanan
                'total_price' => $order->total_price // Opsional: mengembalikan info tambahan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat order: ' . $e->getMessage()
            ], 500);
        }
    }


    public function allOrders()
    {
        try {
            // Mengambil semua order dengan relasi item dan produk di dalamnya
            $orders = \App\Models\Order::with(['orderItems.product', 'kasir'])
                ->orderBy('created_at', 'desc')
                ->get();

            if ($orders->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Belum ada data transaksi',
                    'data' => []
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => 'Semua riwayat transaksi berhasil diambil',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            // Mengambil ID user yang sedang login via Token Sanctum
            $userId = $request->user()->id;

            $orders = \App\Models\Order::with(['orderItems.product'])
                ->where('kasir_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Riwayat pesanan berhasil diambil',
                'data' => $orders
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
