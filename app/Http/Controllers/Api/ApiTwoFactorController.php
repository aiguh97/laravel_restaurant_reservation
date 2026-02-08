<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

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

    // Tambahan untuk alur email jika dibutuhkan
    public function sendEmail()
    {
        // Logika kirim OTP via email jika user memilih type 'email'
        return response()->json(['message' => 'Fitur email OTP belum diimplementasikan.']);
    }
}
