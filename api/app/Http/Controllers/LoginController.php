<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Login the user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validateLogin($request);

        if (!\Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        return response()->json([
            'token' => $request->user()?->createToken($request->str('device'))?->plainTextToken,
            'message' => 'Success'
        ]);
    }

    /**
     * Validate the login request
     *
     * @param Request $request
     * @return array<string, string>
     */
    public function validateLogin(Request $request): array
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device' => 'required'
        ]);
    }
}
