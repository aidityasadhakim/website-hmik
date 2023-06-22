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

    /**
     * @OA\Post(
     *     path="/api/login",
     *     description="This API allows user to login and return a token",
     *     summary="Login a user",
     *     operationId="authenticate",
     *     
     *     @OA\RequestBody(
     *         description="The login",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *              @OA\Property(
     *                     description="Email",
     *                     property="email",
     *                     type="string",
     *                     format="string",
     *                 ),
     *             @OA\Property(
     *                     description="Password",
     *                     property="password",
     *                     type="string",
     *                     format="string",
     *                 ),
     *             required={"email","password"}
     * )
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User Logged In",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *      tags={
     *          "authentication"
     *          }
     * )
     * */

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
