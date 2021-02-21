<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token = JWTAuth::attempt($credentials)){
            $message = new ApiMessages('Unauthorized');
			return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $jwt_token
        ]);

    }
}
