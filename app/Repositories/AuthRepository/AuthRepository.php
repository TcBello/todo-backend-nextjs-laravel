<?php

namespace App\Repositories\AuthRepository;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AuthRepository\BaseAuthRepository;

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
}
