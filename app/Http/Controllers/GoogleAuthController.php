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

                session(['2fa:user:id' => $user->id]);

                return redirect()->route('2fa.challenge');
            }


            // 3. JIKA TIDAK ADA 2FA, LANGSUNG LOGIN
            Auth::login($user);
            return redirect()->intended('/home');
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['email' => 'Terjadi kesalahan login Google.']);
        }
    }
}
