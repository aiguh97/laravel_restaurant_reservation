<?php

use App\Http\Controllers\API\ApiTwoFactorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleAuthControllerApi;
use App\Http\Controllers\Api\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// post login
Route::post('login', [AuthController::class, 'login']);
Route::post('/auth/google', [GoogleAuthControllerApi::class, 'loginOrRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);
// post logout
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/my-orders', [OrderController::class, 'index']);
    Route::get('/orders', [OrderController::class, 'allOrders']);
    Route::get('/orders', [OrderController::class, 'iall']);
    Route::get('/2fa/setup', [ApiTwoFactorController::class, 'setup']);
    Route::post('/2fa/enable', [ApiTwoFactorController::class, 'enable']);
    Route::post('/2fa/disable', [ApiTwoFactorController::class, 'disable']);
    Route::post('/2fa/send-email', [ApiTwoFactorController::class, 'sendEmail']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('/admin/orders', [OrderController::class, 'allOrders']);
});

Route::get('/kitchen/orders', [OrderController::class, 'kitchenOrders']);
Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);


// api resource product
Route::apiResource('products', \App\Http\Controllers\Api\ProductController::class)->middleware('auth:sanctum');

// api resource order
Route::apiResource('orders', \App\Http\Controllers\Api\OrderController::class)->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);
Route::patch('/categories/{category}', [CategoryController::class, 'update']);
Route::patch('/products/{product}', [ProductController::class, 'update']);

// get categories
Route::get('list-categories', [\App\Http\Controllers\Api\CategoryController::class, 'index'])->middleware('auth:sanctum');

// api resource report
Route::get('/reports/summary', [App\Http\Controllers\Api\ReportController::class, 'summary'])->middleware('auth:sanctum');
Route::get('/reports/product-sales', [App\Http\Controllers\Api\ReportController::class, 'productSales'])->middleware('auth:sanctum');
Route::get('/reports/close-cashier', [App\Http\Controllers\Api\ReportController::class, 'closeCashier'])->middleware('auth:sanctum');



// API Resource Tables (Tambahan Baru)
Route::apiResource('tables', \App\Http\Controllers\Api\TableController::class)->middleware('auth:sanctum');
// API Reservation
Route::post('/reservations', [ReservationController::class, 'store'])->middleware('auth:sanctum');
