<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Authentication\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends ApiController
{
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse | \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validated();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('Accredify_Api_Token')->plainTextToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        }
        return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);

    }

    public function show() : JsonResponse
    {
        $user = Auth::user();
        $user = $user->toArray();

        return $this->sendResponse($user, 'User retrieved successfully.');
    }
}
