<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserLoginResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    /**
     * Register a new user
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        return (new UserLoginResource($user))->response()->setStatusCode(201);
    }

    /**
     * Login user
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->login($request->validated());

        if (!$user) {
            return response()->json(['error' => 'Invalid login credentials'], 404);
        }

        return (new UserLoginResource($user))->response();
    }

    /**
     * Destroy token and logout user
     */
    public function logout(): Response
    {
        request()->user()->currentAccessToken()->delete();

        return response()->noContent();
    }
}
