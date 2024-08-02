<?php

namespace App\Repositories\AuthRepository;

use Illuminate\Contracts\Auth\Authenticatable;

interface BaseAuthRepository
{
    public function attempt(array $data): bool;
    public function revokeToken(): bool;
}
