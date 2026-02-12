<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleAuthControllerApi;
use App\Http\Controllers\API\ApiTwoFactorController;

use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TableController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\ReportController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (NO AUTH)
|--------------------------------------------------------------------------
*/

// AUTH
Route::post('/login', [AuthController::class, 'login']);
Route::post('/auth/google', [GoogleAuthControllerApi::class, 'loginOrRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/2fa/verify', [AuthController::class, 'verify2FA']);
Route::post('/2fa/send-email', [ApiTwoFactorController::class, 'sendEmail']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (SANCTUM)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // USER INFO
    Route::get('/user', fn(Request $request) => $request->user());

    // LOGOUT
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | 2FA
    |--------------------------------------------------------------------------
    */
    Route::get('/2fa/setup', [ApiTwoFactorController::class, 'setup']);
    Route::post('/2fa/enable', [ApiTwoFactorController::class, 'enable']);
    Route::post('/2fa/disable', [ApiTwoFactorController::class, 'disable']);

    /*
    |--------------------------------------------------------------------------
    | ORDERS
    |--------------------------------------------------------------------------
    */
    Route::get('/my-orders', [OrderController::class, 'index']);
    Route::get('/admin/orders', [OrderController::class, 'allOrders']);
    Route::get('/kitchen/orders', [OrderController::class, 'kitchenOrders']);
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus']);

    Route::apiResource('orders', OrderController::class);

    /*
    |--------------------------------------------------------------------------
    | PRODUCTS & CATEGORIES
    |--------------------------------------------------------------------------
    */
    Route::apiResource('products', ProductController::class);
    Route::apiResource('categories', CategoryController::class);

    Route::get('/list-categories', [CategoryController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | TABLES & RESERVATIONS
    |--------------------------------------------------------------------------
    */
    Route::apiResource('tables', TableController::class);
    Route::post('/reservations', [ReservationController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | REPORTS
    |--------------------------------------------------------------------------
    */
    Route::get('/reports/summary', [ReportController::class, 'summary']);
    Route::get('/reports/product-sales', [ReportController::class, 'productSales']);
    Route::get('/reports/close-cashier', [ReportController::class, 'closeCashier']);
});
