<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\TwoFactorOtpMail;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorLoginController extends Controller
{
    public function show()
    {
        if (!session()->has('2fa:user:id')) {
            return redirect('/login');
        }

        $user = User::find(session('2fa:user:id'));

        // HANYA tampilkan view, jangan kirim email di sini
        return view('pages.auth.2fa-challenge', ['email' => $user->email]);
    }

    public function sendEmail()
    {
        if (!session()->has('2fa:user:id')) {
            return redirect('/login');
        }

        $user = User::find(session('2fa:user:id'));
        $otp = rand(100000, 999999);

        // Simpan OTP email ke session
        session([
            '2fa:otp' => $otp,
            '2fa:otp_expires_at' => now()->addMinutes(10)
        ]);

        try {
            Mail::to($user->email)->send(new TwoFactorOtpMail($otp));
            return back()->with('success', 'Kode OTP telah dikirim ke email Anda.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan gunakan Google Authenticator.');
        }
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        if (!session()->has('2fa:user:id')) {
            return redirect('/login');
        }

        $user = User::find(session('2fa:user:id'));

        // --- CEK 1: Verifikasi via OTP Email (jika ada di session) ---
        if (session()->has('2fa:otp')) {
            if ($request->code == session('2fa:otp')) {
                if (now()->lt(session('2fa:otp_expires_at'))) {
                    return $this->loginUser($user);
                } else {
                    session()->forget(['2fa:otp', '2fa:otp_expires_at']);
                    return back()->withErrors(['code' => 'Kode email sudah kadaluwarsa.']);
                }
            }
        }

        // --- CEK 2: Verifikasi via Google Authenticator ---
        $google2fa = new Google2FA();
        try {
            $secret = decrypt($user->two_factor_secret);
            // Gunakan window = 4 untuk toleransi waktu 2 menit
            $valid = $google2fa->verifyKey($secret, $request->code, 4);

            if ($valid) {
                return $this->loginUser($user);
            }
        } catch (\Exception $e) {
            // Handle jika dekripsi gagal
        }

        return back()->withErrors(['code' => 'Kode OTP tidak valid atau sudah kadaluwarsa.']);
    }

    private function loginUser($user)
    {
        Auth::login($user);
        session()->forget(['2fa:user:id', '2fa:otp', '2fa:otp_expires_at']);
        request()->session()->regenerate();
        return redirect()->route('home');
    }
}
