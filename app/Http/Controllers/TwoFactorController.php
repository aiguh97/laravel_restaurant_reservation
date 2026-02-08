<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA; // Gunakan versi QRCode agar lebih mudah

class TwoFactorController extends Controller
{
    public function setup()
    {
        $user = Auth::user();
        $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();

        if ($user->two_factor_enabled) {
            return redirect()->route('settings.index');
        }

        // Jika secret kosong atau rusak, buat baru dan simpan paksa
        if (empty($user->two_factor_secret)) {
            $newSecret = $google2fa->generateSecretKey();
            $user->two_factor_secret = encrypt($newSecret);
            $user->save(); // Paksa simpan ke DB

            $secret = $newSecret;
        } else {
            try {
                $secret = decrypt($user->two_factor_secret);
            } catch (\Exception $e) {
                $newSecret = $google2fa->generateSecretKey();
                $user->two_factor_secret = encrypt($newSecret);
                $user->save();
                $secret = $newSecret;
            }
        }

        $qrCodeInline = $google2fa->getQRCodeInline(
            config('app.name'),
            $user->email,
            $secret
        );

        return view('pages.settings.two-factor', [
            'qrCode' => $qrCodeInline,
            'secret' => $secret,
        ]);
    }

    public function enable(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $user = Auth::user();

        if (!$user->two_factor_secret) {
            return redirect()->route('2fa.setup')->with('error', 'Secret tidak ditemukan.');
        }

        try {
            // Dekripsi secret
            $secret = decrypt($user->two_factor_secret);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Jika payload rusak, reset secret dan minta user setup ulang
            $user->update(['two_factor_secret' => null]);
            return redirect()->route('2fa.setup')->with('error', 'Data enkripsi tidak valid. Silahkan scan ulang QR Code.');
        }

        $google2fa = new \PragmaRX\Google2FAQRCode\Google2FA();

        // Verifikasi dengan toleransi waktu (window = 4)
        $valid = $google2fa->verifyKey($secret, $request->code, 4);

        if (!$valid) {
            return back()->withErrors(['code' => 'Kode OTP salah atau waktu server tidak sinkron.']);
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_type' => 'authenticator',
        ]);

        return redirect()->route('settings.index')
            ->with('success', 'Two-Factor Authentication berhasil diaktifkan.');
    }

    public function disable(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_secret' => null, // Opsional: hapus secret agar bisa generate baru nanti
            // 'two_factor_type' => null,
        ]);

        return back()->with('success', 'Two-Factor Authentication telah dinonaktifkan.');
    }
}
