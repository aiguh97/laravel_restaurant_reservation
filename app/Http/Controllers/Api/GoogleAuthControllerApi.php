<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

class GoogleAuthControllerApi extends Controller
{
    // File: App\Http\Controllers\Api\GoogleAuthControllerApi.php

    public function loginOrRegister(Request $request)
    {
        $request->validate(['id_token' => 'required|string']);

        try {
            $googleUser = Socialite::driver('google')->stateless()->userFromToken($request->id_token);

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => Hash::make(bin2hex(random_bytes(8))), // password random lebih aman
                ]);
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id, 'avatar' => $googleUser->avatar]);
                }
            }

            // 🔐 CEK APAKAH 2FA AKTIF (Sama seperti AuthController)
            if ($user->two_factor_enabled) {
                // Kita panggil logika challenge yang sama
                $token = bin2hex(random_bytes(32));
                $user->update([
                    'two_factor_login_token' => hash('sha256', $token),
                    'two_factor_login_expires_at' => now()->addMinutes(5),
                ]);

                return response()->json([
                    'message' => '2FA_REQUIRED', // Label yang sama agar Flutter mengenali
                    'two_factor_token' => $token,
                    'user_id' => $user->id,
                    'email' => $user->email,
                ], 200);
            }

            // JIKA TIDAK AKTIF, LANGSUNG TOKEN
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Google authentication gagal', 'error' => $e->getMessage()], 401);
        }
    }
}
