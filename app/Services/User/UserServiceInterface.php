<?php
namespace App\Services\User;
interface UserServiceInterface
{
    public function register(array $data): array;
    public function login(array $credentials): array;
    public function recoverPassword(string $email): void;
}
