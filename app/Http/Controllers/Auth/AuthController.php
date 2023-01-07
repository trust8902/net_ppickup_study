<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
        return response()->json([], 200);
    }

    public function login(Request $request) {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(auth()->attempt($request->only(['email', 'password']))) {
//            $user = User::where('email', $request->email)->first();
//            $token = $user->createToken('test token')->accessToken;
//
//            return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);

            $token = auth()->user()->createToken('LaravelAuthApp')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
