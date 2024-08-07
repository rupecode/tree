<?php

namespace App\Repositories;

use App\Services\PasswordService;
use Aura\Sql\ExtendedPdo;

class UsersRepository
{
    public function __construct(private ExtendedPdo $pdo, private PasswordService $passwordService)
    {
    }

    public function getUser(string $email, string $password): array
    {
        $user = $this->pdo->fetchOne(
            'SELECT * FROM users WHERE email=:email AND password=:password',
            [
                'email' => $email,
                'password' => $this->passwordService->hash($password),
            ]
        );

        if (!$user) {
            throw new \Exception('User not found');
        }

        return $user;
    }
}
