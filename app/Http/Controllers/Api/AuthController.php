<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Tambahkan baris import di bawah ini:
use App\Models\User;
use PragmaRX\Google2FA\Google2FA;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Email atau Password salah'], 401);
        }

        // 🔐 CEK APAKAH 2FA AKTIF
        if ($user->two_factor_enabled) {
            return response([
                'message' => '2FA_REQUIRED',
                'user_id' => $user->id,
                'email' => $user->email,
            ], 200); // Status 200 agar Flutter tahu ini bukan error, tapi proses lanjut
        }

        // JIKA TIDAK AKTIF, LANGSUNG BERIKAN TOKEN
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
    }


    public function verify2FA(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code'    => 'required|digits:6',
        ]);

        $user = User::find($request->user_id);
        $google2fa = new Google2FA();

        // 1. Cek OTP dari Database (Jika Anda mengirim via Email)
        $isOtpEmailValid = session()->has('2fa:otp') &&
            session('2fa:otp') == $request->code &&
            now()->lt(session('2fa:otp_expires_at'));

        // 2. Cek OTP dari Authenticator App
        $secret = $user->two_factor_secret ? decrypt($user->two_factor_secret) : null;
        $isOtpAppValid = $secret ? $google2fa->verifyKey($secret, $request->code, 4) : false;

        // Validasi salah satu (Email atau App)
        if ($isOtpEmailValid || $isOtpAppValid) {

            // Hapus session OTP email jika ada
            session()->forget(['2fa:otp', '2fa:otp_expires_at']);

            // Buat Token Sanctum
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
                'message' => 'Login success'
            ], 200);
        }

        return response()->json([
            'message' => 'Kode OTP tidak valid atau sudah kedaluwarsa.'
        ], 401);
    }


    //logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }
}
