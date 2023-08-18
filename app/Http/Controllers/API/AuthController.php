<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use GuzzleHttp\Promise\Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
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

    public function addMultipleUser(Request $request)
    {
        $usersData = [];

        // Generate 100 random users
        for ($i = 0; $i < 100; $i++) {
            $usersData[] = [
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('12121212'),
            ];
        }

        // Start the timer
        $startTime = microtime(true);

        try {
            DB::beginTransaction();

            // Chunk the user data into smaller batches (optional)
            $batches = array_chunk($usersData, 100);

            foreach ($batches as $batch) {
                User::insert($batch);
            }

            DB::commit();

            // Calculate the total execution time
            $executionTime = microtime(true) - $startTime;

            // Log the execution time
            Log::info("Execution time: {$executionTime} seconds");

            return response()->json(['message' => 'Users added successfully', 'execution_time' => $executionTime]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to add multiple users: ' . $e->getMessage());

            return response()->json(['message' => 'Failed to add multiple users'], 500);
        }
    }
}
