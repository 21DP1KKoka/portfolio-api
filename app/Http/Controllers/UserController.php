<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function register(RegisterRequest $request) {

        $user = User::create($request->all());
        $token = $user->createToken('auth_token', expiresAt: now()->addDay())->plainTextToken;
        return response()->json(['user' => new UserResource($user), 'token' => $token], 201);
    }

    public function login(LoginRequest $request) {

        $loginCredentials = $request->all();
        $success = Auth::attempt($loginCredentials);
        if (!$success) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        } // Unauthorized

        $user_model = Auth::user();
        $token = $user_model->createToken('auth_token', expiresAt: now()->addDay())->plainTextToken;

        return response()->json(['user' => new UserResource($user_model), 'token' => $token], 200); // OK
    }

    public function logout() {
        $user_model = Auth::user();
        $user_model->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
