<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function register(array $data): array
    {
        if (!isset($data['password'])) {
            throw new \Exception("Password is required");
        }
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);

        $token = JWTAuth::fromUser($user);
        return [
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
            'token' => $token,
        ];
    }

    /**
     * @param array $credentials
     * @return array
     * @throws ValidationException
     */
    public function login(array $credentials): array
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages(['error' => 'Invalid credentials']);
        }

        $token = JWTAuth::fromUser($user);

        return [
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
            ],
            'token' => $token,
        ];
    }

    public function recoverPassword(string $email): void
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            throw ValidationException::withMessages(['error' => 'User not found.']);
        }
        $token = Str::random(60);
        try {
            Mail::send('emails.recover_password', ['token' => $token], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Password Recovery');
            });
        } catch (Exception $e) {
            \Log::error('Error sending email: ' . $e->getMessage());
        }
    }
}

