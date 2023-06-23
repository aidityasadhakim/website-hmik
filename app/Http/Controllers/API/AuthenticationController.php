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
use PhpParser\Node\Expr\New_;

class AuthenticationController extends Controller
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

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     description="This API allows user to logout",
     *     summary="Logout a user",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response="200",
     *         description="User Logged Out",
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

    public function logout()
    {
        try {
            $user_id = auth('api')->user()->token()->revoke();
            if ($user_id) {
                return Response::success("User successfully logged out", "User Logged Out", HttpStatus::$OK);
            } else {
                throw new Exception("User failed to log out");
            }
        } catch (\Throwable $e) {
            return Response::error($e->getMessage(), HttpStatus::$BAD_REQUEST);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     description="This API will register a new user",
     *     summary="Register a new user",
     *     operationId="register",
     * 
     *     @OA\RequestBody(
     *          description="Register Payload",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      description="Name",
     *                      property="name",
     *                      type="string",
     *                      format="string",
     *                  ),
     *                  @OA\Property(
     *                      description="Username",
     *                      property="username",
     *                      type="string",
     *                      format="string",
     *                  ),
     *                  @OA\Property(
     *                      description="Email",
     *                      property="email",
     *                      type="string",
     *                      format="string",
     *                  ),
     *                  @OA\Property(
     *                      description="Password",
     *                      property="password",
     *                      type="string",
     *                      format="string",
     *                  ),
     *                      required={"name","username","email","password"}
     *              )
     *          ),
     *      ),
     *     @OA\Response(
     *         response="200",
     *         description="User Created",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     *      tags={
     *          "authentication"
     *          }
     * )
     * */

    function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'username' => ['required', 'min:3', 'max:255', 'unique:users'],
                'email' => 'required|email:dns|unique:users',
                'password' => 'required|min:5|max:255'
            ]);

            // $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['password'] = Hash::make($validatedData['password']);

            $user = User::create($validatedData);

            return Response::success($user, "User Registered Successfully", HttpStatus::$CREATED);
        } catch (\Throwable $e) {
            return Response::error($e->getMessage(), HttpStatus::$BAD_REQUEST);
        }
    }
}
