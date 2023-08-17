<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

public function login(Request $request)
{

    $credentials = $request->only('email', 'password');

    if (Auth::guard('web')->attempt($credentials)) {
        $user = Auth::guard('web')->user();
            $user = User::where('email', $user->email)->update([
                'api_token' => Str::random(60)
            ]);
        return response()->json($user);
    }

    return response()->json(['message' => 'Something went wrong'], 401);
}

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(
            [
                'message' => 'Register Successful',
                'user' => $user,
                'access_token' => $accessToken,
            ],
            201,
        );
    }

    public function logout(){
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Logout Successful'], 200);
    }
}
