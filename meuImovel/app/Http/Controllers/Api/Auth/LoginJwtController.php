<?php

namespace App\Http\Controllers\Api\Auth;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginJwtController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        Validator::make($credentials, [
            'email' => 'required|string',
            'password' => 'required|string'
        ])->validate();

        $jwt_token = null;

        if (!$jwt_token = auth('api')->attempt($credentials)){
            $message = new ApiMessages('Unauthorized');
			return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $jwt_token
        ], 200);

    } 
    
    public function logout()
    {

        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function refresh()
    {
        $jwt_token = auth('api')->refresh();

        return response()->json([
            'token' => $jwt_token
        ], 200);
    }

}
