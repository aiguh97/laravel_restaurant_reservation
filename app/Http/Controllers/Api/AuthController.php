<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Tambahkan baris import di bawah ini:
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function verify2FA(Request $request)
{
    $request->validate([
        'user_id' => 'required',
        'code' => 'required',
        'two_factor_token' => 'required' // Pastikan Flutter mengirim ini
    ]);

    $user = User::find($request->user_id);

    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }

    // 1. Cek OTP dari Email (Cache)
    $emailOtp = Cache::get("2fa_otp_{$user->id}");
    $isEmailValid = ($emailOtp && $emailOtp == $request->code);

    // 2. Cek OTP dari Google Authenticator (jika email tidak valid)
    $isGoogleValid = false;
    if (!$isEmailValid && $user->two_factor_secret) {
        $google2fa = new \PragmaRX\Google2FA\Google2FA();
        $secret = decrypt($user->two_factor_secret);
        $isGoogleValid = $google2fa->verifyKey($secret, $request->code);
    }

    // 3. Validasi Akhir
    if ($isEmailValid || $isGoogleValid) {
        // Hapus OTP email jika sukses
        Cache::forget("2fa_otp_{$user->id}");

        // BUAT TOKEN SANCTUM (Ini pengganti issueToken yang error tadi)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Authenticated',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->roles, // Sesuaikan field roles Anda
                'two_factor_enabled' => true,
            ],
        ], 200);
    }

    return response()->json(['message' => 'Kode OTP tidak valid atau kadaluarsa'], 401);
}

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil',
            'user'    => $user,
            'token'   => $token,
        ], 201);
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

    protected function create2FAChallenge($user)
    {
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
        ], 200);
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
            return $this->create2FAChallenge($user);
        }


        // JIKA TIDAK AKTIF, LANGSUNG BERIKAN TOKEN
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token,
        ], 200);
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
