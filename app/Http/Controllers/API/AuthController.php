<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nis'   => 'required|integer',
            'token' => 'required|string|max:225'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data is invalid!',
                'errors'  => $validator->errors()->all()
            ], 500);
        }

        $credentials = [
            'email'    => (string) $request->nis . ConfigVoting::getConfig()->email_prefix,
            'password' => $request->token
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login failed, please check nis or token'
            ], 500);
        }

        return response()->json([
            'message'      => 'You have successfully logged in',
            'access_token' => Auth::user()->createToken('access_token')->plainTextToken,
            'token_type'   => 'Bearer'
        ]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'You have successfully logged out'
        ]);
    }
}
