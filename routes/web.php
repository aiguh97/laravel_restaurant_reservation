<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\{
    UserController,
    SettingController,
    TwoFactorController,
    TwoFactorLoginController,
    ProductController,
    OrderController,
    CategoryController,
    GoogleAuthController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

// Landing Page
Route::view('/', 'welcome')->name('welcome');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

// Login Page
Route::view('/login', 'pages.auth.login')->name('login');

// Process Login
Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    $user = Auth::user();

    // Jika 2FA aktif
    if ($user->two_factor_enabled) {
        session(['2fa:user:id' => $user->id]);
        Auth::logout();
        return redirect()->route('2fa.challenge');
    }

    $request->session()->regenerate();

    return redirect()->route('home');

})->name('login.process');


// Google OAuth
Route::prefix('auth')->group(function () {
    Route::get('google', [GoogleAuthController::class, 'redirectToGoogle'])
        ->name('google.login');

    Route::get('google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});


// Logout
Route::post('/logout', function (Request $request) {

    Auth::logout();

    $request->session()->forget('2fa:user:id');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');

})->name('logout');


/*
|--------------------------------------------------------------------------
| 2FA CHALLENGE (NOT AUTH)
|--------------------------------------------------------------------------
*/

Route::prefix('2fa')->name('2fa.')->group(function () {

    Route::get('/challenge', [TwoFactorLoginController::class, 'show'])
        ->name('challenge');

    Route::post('/challenge', [TwoFactorLoginController::class, 'verify'])
        ->name('challenge.verify');

    Route::post('/challenge/send-email', [TwoFactorLoginController::class, 'sendEmail'])
        ->name('challenge.send-email');

});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::view('/home', 'pages.dashboard')->name('home');

    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::resource('categories', CategoryController::class);

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])
        ->name('settings.index');

    /*
    |--------------------------------------------------------------------------
    | 2FA SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::prefix('settings/2fa')->name('2fa.')->group(function () {

        Route::get('/', [TwoFactorController::class, 'setup'])
            ->name('setup');

        Route::post('/', [TwoFactorController::class, 'enable'])
            ->name('enable');

        Route::post('/disable', [TwoFactorController::class, 'disable'])
            ->name('disable');

    });

});


/*
|--------------------------------------------------------------------------
| DEBUG / TEST ONLY (REMOVE IN PRODUCTION)
|--------------------------------------------------------------------------
*/

Route::get('/minio-test', function () {

    try {
        Storage::disk('s3')->put('test-file.txt', 'Halo MinIO!');
        return "Upload Berhasil!";
    } catch (\Exception $e) {
        return "Gagal: " . $e->getMessage();
    }

})->name('minio.test');
