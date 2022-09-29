<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\ErrorResponses;

class AuthController extends Controller
{
    use ErrorResponses;

    /**
     * Create a new AuthController instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['login']
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        $token = auth('api')->attempt($credentials);

        return ($token)
            ? $this->respondWithToken($token)
            : $this->unauthorized();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = auth('api')->user();

        return response()->json($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $credentials = auth('api')->refresh();

        return $this->respondWithToken($credentials);
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
        $expiration = auth('api')->factory()->getTTL() * 60;

        $tokenType = 'bearer';

        return response()->json([
            'access_token' => $token,
            'token_type'   => $tokenType,
            'expires_in'   => $expiration,
        ]);
    }
}
