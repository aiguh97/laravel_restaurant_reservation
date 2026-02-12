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


   public function verify2FA(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'code' => 'required|digits:6',
        'two_factor_token' => 'required|string'
    ]);

    $user = User::find($request->user_id);

    // validasi temporary login token
    if (
        !$user->two_factor_login_token ||
        !hash_equals($user->two_factor_login_token, hash('sha256', $request->two_factor_token)) ||
        now()->gt($user->two_factor_login_expires_at)
    ) {
        return response()->json([
            'message' => 'Sesi login 2FA tidak valid atau kedaluwarsa'
        ], 401);
    }

    $google2fa = new \PragmaRX\Google2FA\Google2FA();

    $secret = $user->two_factor_secret ? decrypt($user->two_factor_secret) : null;
    $isOtpValid = $secret && $google2fa->verifyKey($secret, $request->code, 4);

    if (!$isOtpValid) {
        return response()->json([
            'message' => 'Kode OTP salah'
        ], 401);
    }

    // hapus challenge
    $user->update([
        'two_factor_login_token' => null,
        'two_factor_login_expires_at' => null,
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login success',
        'token' => $token,
        'user' => $user
    ]);
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
