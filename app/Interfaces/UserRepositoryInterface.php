<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function findByEmail(string $email): ?User;
    // public function createToken(User $user, string $tokenName): string;
    // public function deleteTokens(User $user): void;
}
