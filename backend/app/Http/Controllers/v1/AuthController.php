<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    use HttpResponses;

    public function login(LoginRequest $request){

        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->error(null, 'Invalid credentials', Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return $this->error(null, 'INTERNAL SERVER ERROR', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return $this->respondWithToken($token);
    }

    public function register(RegisterRequest $request){
        
        try{
            User::create(
                [
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                ]
            );

            return $this->success(null, 'Registration successful. Please proceed to login.');
        }catch(Exception $e){
            return $this->error(null, 'An unexpected error occurred during registration. Please try again later', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->success(null, 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
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
        return $this->success([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 1,
            // 'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
