<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     *
     * give the user login acess.
     *
     * @OA\Post(
     *     path="/api/v1/login",
     *     tags={"auth"},
     *     summary="Returns user details and authentication",
     *     description="Returns a map of status codes to quantities",
     *     operationId="login",
     *     @OA\RequestBody(
     *       required=true,
     *       description="Pass user details",
     *       @OA\JsonContent(
     *          required={"email" ,"password"},
     *            @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
     *            @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
     *       ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful login",
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *     )
     * )
     */
    public function login (Request $request) {

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // dd($token);

        return $this->respondWithToken($token);
    }

    /**
     *
     * give the user logout acess.
     *
     * @OA\Get(
     *     path="/api/v1/logout",
     *     tags={"auth"},
     *     operationId="logout",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *     ),
     *     security={{"bearer_token":{}}}
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            auth()->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
