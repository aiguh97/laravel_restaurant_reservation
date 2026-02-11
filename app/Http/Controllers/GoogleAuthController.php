<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            // SYARAT 1: JIKA USER TIDAK ADA, JANGAN REGISTER (TOLAK)
            if (!$user) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Google Anda belum terdaftar di sistem kami.'
                ]);
            }

            // SYARAT 2: CEK 2FA (Sesuai database kamu: two_factor_enabled)
            if ($user->two_factor_enabled) {
                // Simpan ID user di session sementara untuk verifikasi 2FA
                session(['login.id' => $user->id]);

                // Arahkan ke halaman verifikasi 2FA Fortify atau view custom kamu
                return redirect()->route('two-factor.login');
            }

            // JIKA TIDAK ADA 2FA, LANGSUNG LOGIN
            Auth::login($user);
            return redirect()->intended('/home');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Gagal login via Google.']);
        }
    }
}
