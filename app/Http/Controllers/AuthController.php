<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RecoverUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\User\UserServiceInterface;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): array
    {
        try {
            $result = $this->userService->register($request->json()->all());
        } catch (ValidationException $e) {
            return ['error' => 'Invalid registration', 'exception' => $e->getMessage()];
        }
        return $result;
    }

    public function login(LoginRequest $request): array
    {
        try {
            $result = $this->userService->login($request->json()->all());
        } catch (ValidationException $e) {
            return ['error' => 'Invalid credentials', 'exception' => $e->getMessage()];
        }
        return $result;
    }

    public function recoverPassword(RecoverUserRequest $request): array
    {
        try {
            $this->userService->recoverPassword($request->json()->get('email'));
        } catch (ValidationException $e) {
            return ['error' => 'User not found', 'exception' => $e->getMessage()];
        }
        return ['message' => 'Password recovery email sent'];
    }
}
