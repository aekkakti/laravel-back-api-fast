<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function login(LoginRequest $request) {
        if (!Auth::attempt($request->only(['email', 'password']))) throw new ApiException(401, 'Login failed');
        $user = $request->user();

        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Success',
            'token' => $user->createToken('AuthToken')->plainTextToken
        ]);
    }

    public function register(RegisterRequest $request) {
        return [
            'success' => true,
            'code' => 200,
            'message' => 'Success',
            'token' => User::create($request->except('password') + ['password' => Hash::make($request->password)])
                ->createToken('authToken')->plainTextToken
        ];
    }

    public function logout(Request $request) {

        $user = $request->user();

        $user->token->each(function ($token) {
            $token->delete();
        });
        return response()->json([], 204);
    }
}
