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
        $user = User::where('email', $googleUser->getEmail())->first();

        // 1. CEK APAKAH USER ADA (HANYA LOGIN, TIDAK REGISTER)
        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akun tidak terdaftar. Silakan hubungi admin.'
            ]);
        }

        // 2. CEK APAKAH 2FA AKTIF (Berdasarkan model kamu: two_factor_enabled)
        if ($user->two_factor_enabled) {
            // Jangan login dulu! Simpan data sementara di session
            session(['2fa:user_id' => $user->id]);

            // Redirect ke halaman input kode OTP (bukan langsung masuk dashboard)
            return redirect()->route('two-factor.login');
        }

        // 3. JIKA TIDAK ADA 2FA, LANGSUNG LOGIN
        Auth::login($user);
        return redirect()->intended('/home');

    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors(['email' => 'Terjadi kesalahan login Google.']);
    }
}
}
