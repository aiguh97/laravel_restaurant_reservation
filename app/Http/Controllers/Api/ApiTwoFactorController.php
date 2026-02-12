<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ApiTwoFactorController extends Controller
{
    public function setup()
    {
        $user = Auth::user();
        $google2fa = new Google2FA();

        if ($user->two_factor_enabled) {
            return response()->json([
                'status' => 'error',
                'message' => 'Two-Factor Authentication sudah aktif.'
            ], 400);
        }

        // Logika Generate/Decrypt Secret (Sesuai logika controller Anda)
        if (empty($user->two_factor_secret)) {
            $secret = $google2fa->generateSecretKey();
            $user->two_factor_secret = encrypt($secret);
            $user->save();
        } else {
            try {
                $secret = decrypt($user->two_factor_secret);
            } catch (\Exception $e) {
                $secret = $google2fa->generateSecretKey();
                $user->two_factor_secret = encrypt($secret);
                $user->save();
            }
        }

        // Generate QR Code untuk Mobile
        $qrCodeInline = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'qr_code' => $qrCodeInline, // Ini berisi data:image/png;base64,...
                'secret' => $secret,
            ]
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if (!$user->two_factor_secret) {
            return response()->json(['message' => 'Secret tidak ditemukan.'], 404);
        }

        try {
            $secret = decrypt($user->two_factor_secret);
        } catch (\Exception $e) {
            $user->update(['two_factor_secret' => null]);
            return response()->json(['message' => 'Data enkripsi rusak.'], 400);
        }

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($secret, $request->code, 4);

        if (!$valid) {
            return response()->json(['message' => 'Kode OTP salah atau tidak sinkron.'], 422);
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_type' => 'authenticator',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Two-Factor Authentication berhasil diaktifkan.'
        ]);
    }

    public function disable(Request $request)
    {
        $user = Auth::user();
        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Two-Factor Authentication dinonaktifkan.'
        ]);
    }

  public function sendEmail(Request $request)
{
    // 1. Validasi input
    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $userId = $request->user_id;
    $user = User::find($userId);

    // 2. Definisi Key unik untuk Redis
    $key = 'send-otp-email:' . $userId;

    // 3. Cek Limit (Hanya boleh 1 kali per 30 detik)
    if (RateLimiter::tooManyAttempts($key, 1)) {
        $seconds = RateLimiter::availableIn($key);
        return response()->json([
            'status' => false,
            'message' => "Tunggu $seconds detik untuk mengirim ulang kode OTP."
        ], 429);
    }

    // 4. Generate OTP & Simpan di Cache (Redis)
    $otp = random_int(100000, 999999);
    Cache::put("2fa_otp_{$userId}", $otp, now()->addMinutes(10));

    try {
        // 5. Kirim Email
        Mail::to($user->email)->send(new \App\Mail\TwoFactorOtpMail($otp));

        // 6. Catat percobaan (Hit) dengan decay time 30 detik
        RateLimiter::hit($key, 30);

        return response()->json([
            'status' => true,
            'message' => 'Kode OTP baru telah dikirim ke ' . $user->email,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Gagal mengirim email: ' . $e->getMessage()
        ], 500);
    }
}
}
