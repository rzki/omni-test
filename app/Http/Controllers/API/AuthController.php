<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            $user = Auth::guard('web')->user();
            $user = User::where('email', $user->email)->update([
                'api_token' => Str::random(60),
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

    public function logout()
    {
        Auth::guard('web')->logout();
        return response()->json(['message' => 'Logout Successful'], 200);
    }

    public function addMultipleUser(){
        $usersData = []; // Array to store user data

        // Generate 100 user data
        for ($i = 0; $i < 100; $i++) {
            $usersData[] = [
                'name' => 'User ' . Str::random(5),
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('tested11'),
            ];
        }

        // Chunk the user data into smaller batches (optional)
        $batches = array_chunk($usersData, 10);

        // Start the timer
        $startTime = microtime(true);

        // Process the requests asynchronously
        $responses = [];
        foreach ($batches as $batch) {
            $responses[] = Http::asJson()->post('/api/add-multiple-user', $batch);
        }

        // Wait for all responses to complete
        $responses = collect($responses)->pluck('result')->map(fn ($response) => $response->wait())->all();

        // Calculate the total execution time
        $executionTime = microtime(true) - $startTime;

        // Log the execution time
        Log::info("Execution time: {$executionTime} seconds");

        // Process the responses
        foreach ($responses as $response) {
            if ($response->successful()) {
                // Handle successful response
                return $response->json();
            } else {
                // Handle failed response
                Log::error('Failed to create user: ' . $response->body());
            }
        }
    }
}
