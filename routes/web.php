<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

// 1. Halaman Depan (Root)
Route::get('/', function () {
   return View('welcome');
});
Route::get('/login', function () {
    return view('pages.auth.login'); // Pastikan menggunakan huruf kecil 'view'
})->name('login');

Route::get('/minio-test', function () {
    Storage::disk('s3')->put('test.txt', 'hello from laravel');
    return 'OK';
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');



Route::get('/test-upload', function () {
    try {
        Storage::disk('s3')->put('test-file.txt', 'Halo MinIO!');
        return "Upload Berhasil! Cek di dashboard MinIO kamu.";
    } catch (\Exception $e) {
        return "Gagal: " . $e->getMessage();
    }
});

// 2. Auth & Login
Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (!Auth::attempt($credentials)) {
        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    $user = Auth::user();

    if ($user->two_factor_enabled) {
        session(['2fa:user:id' => $user->id]);
        Auth::logout();
        return redirect()->route('2fa.challenge');
    }

    $request->session()->regenerate();
    return redirect()->route('home');
})->name('login');

Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
// 3. Challenge 2FA (Setelah Login Berhasil tapi sebelum masuk Dashboard)
Route::get('/2fa-challenge', [TwoFactorLoginController::class, 'show'])->name('2fa.challenge');
Route::post('/2fa-challenge', [TwoFactorLoginController::class, 'verify'])->name('2fa.challenge.verify');
Route::get('/2fa-challenge/send-email', [TwoFactorLoginController::class, 'sendEmail'])
    ->name('2fa.challenge.send-email');
// 4. Protected Routes (Harus Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('pages.dashboard');
    })->name('home');

    Route::resource('user', UserController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::resource('product', ProductController::class);
    Route::resource('order', OrderController::class);
    Route::resource('categories', CategoryController::class);

    // Setup 2FA
    Route::get('/settings/2fa', [TwoFactorController::class, 'setup'])->name('2fa.setup');
    Route::post('/settings/2fa', [TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/settings/2fa/disable', [TwoFactorController::class, 'disable'])
        ->name('2fa.disable');
});
