<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use App\Helpers\Response;
use App\Helpers\HttpStatus;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = User::where('email', $credentials['email'])->first();
            if (!$user) {
                throw new Exception("User not found", 1);
            }
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken($user->name)->accessToken;
                return Response::success([
                    "user" => $user,
                    "token" => $token
                ], "User Logged in successfully", HttpStatus::$OK);
            }
        } catch (Exception $e) {
            return Response::error($e->getMessage(), HttpStatus::$BAD_REQUEST);
        }

        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        $user_id = auth('api')->user()->token()->revoke();
        return $user_id; // modify as per your need
    }
}
