<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Http;

class GoogleAuthControllerApi extends Controller
{
    // File: App\Http\Controllers\Api\GoogleAuthControllerApi.php



public function loginOrRegister(Request $request)
{
    $request->validate([
        'id_token' => 'required|string'
    ]);

    try {
        // 🔥 Verifikasi ID TOKEN ke Google
        $response = Http::get(
            'https://oauth2.googleapis.com/tokeninfo',
            ['id_token' => $request->id_token]
        );

        if (!$response->ok()) {
            return response()->json([
                'message' => 'Invalid Google token'
            ], 401);
        }

        $googleUser = $response->json();

        /*
        Response dari Google:
        {
          "sub": "123456",
          "email": "user@gmail.com",
          "name": "Teguh",
          "picture": "https://..."
        }
        */

        $user = User::where('google_id', $googleUser['sub'])
            ->orWhere('email', $googleUser['email'])
            ->first();

        if (!$user) {
            $user = User::create([
                'name' => $googleUser['name'] ?? 'Google User',
                'email' => $googleUser['email'],
                'google_id' => $googleUser['sub'],
                'avatar' => $googleUser['picture'] ?? null,
                'password' => bcrypt(str()->random(16)),
            ]);
        } else {
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser['sub'],
                    'avatar' => $googleUser['picture'] ?? null
                ]);
            }
        }

        // ====== 2FA CHECK ======
        if ($user->two_factor_enabled) {
            $token = bin2hex(random_bytes(32));

            $user->update([
                'two_factor_login_token' => hash('sha256', $token),
                'two_factor_login_expires_at' => now()->addMinutes(5),
            ]);

            return response()->json([
                'message' => '2FA_REQUIRED',
                'two_factor_token' => $token,
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }

        // ====== CREATE SANCTUM TOKEN ======
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Google authentication gagal',
            'error' => $e->getMessage()
        ], 500);
    }
}

}
