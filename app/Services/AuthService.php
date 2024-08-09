<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository\AuthRepository;
use Illuminate\Foundation\Auth\User as Authenticatable;

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

    public function user(): ?Authenticatable
    {
        return $this->authRepo->user();
    }

    public function createToken(): string
    {
        return $this->authRepo->createToken();
    }

    public function register(array $data): User
    {
        return $this->authRepo->register($data);
    }
}
