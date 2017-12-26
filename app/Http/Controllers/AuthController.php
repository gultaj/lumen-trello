<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {

            if (! $token = $this->jwt->attempt($request->only('email', 'password'))) {
                return response()->json(['email' => 'User with that email is not found'], 401);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], 500);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent' => $e->getMessage()], 500);

        }

        $user = $this->jwt->user();

        return response()->json(compact('token', 'user'));
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users|max:255',
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = \App\User::create([
        // $user = \App\User::create($request->all());
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => app('hash')->make($request->input('password')),
        ]);
        return response()->json(['User registered'], 200);
    }
}