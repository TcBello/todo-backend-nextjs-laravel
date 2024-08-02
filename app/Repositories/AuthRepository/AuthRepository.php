<?php

namespace App\Repositories\AuthRepository;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthRepository\BaseAuthRepository;
use App\Models\User;

class AuthRepository implements BaseAuthRepository
{
    public function attempt(array $data): bool
    {
        return Auth::attempt($data);
    }

    public function revokeToken(): bool
    {
        return auth()->user()->token()->revoke();
    }

    public function user(): ?Authenticatable
    {
        return Auth::user();
    }

    public function createToken(): string
    {
        return Auth::user()->createToken("access-token")->accessToken;
    }

    public function register(array $data): User
    {
        $user = User::create($data);

        return $user;
    }
}
