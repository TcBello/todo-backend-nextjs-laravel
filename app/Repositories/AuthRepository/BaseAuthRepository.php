<?php

namespace App\Repositories\AuthRepository;

use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface BaseAuthRepository
{
    public function attempt(array $data): bool;
    public function revokeToken(): bool;
    public function user(): ?Authenticatable;
    public function createToken(): string;
    public function register(array $data): User;
}
