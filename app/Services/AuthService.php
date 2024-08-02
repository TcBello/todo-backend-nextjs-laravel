<?php

namespace App\Services;

use App\Repositories\AuthRepository\AuthRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthService
{
    protected $authRepo;

    public function __construct(AuthRepository $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    public function attempt(array $data): bool
    {
        return $this->authRepo->attempt($data);
    }

    public function revokeToken(): bool
    {
        return $this->authRepo->revokeToken();
    }
}
