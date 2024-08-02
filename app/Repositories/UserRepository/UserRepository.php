<?php

namespace App\Repositories\UserRepository;

use App\Repositories\UserRepository\BaseUserRepository;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements BaseUserRepository
{
    public function findAll(): Collection
    {
        return User::all();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(string $id, array $data): ?User
    {
        $user = $this->findById($id);

        if ($user) {
            $user->update($data);
            return $user;
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $user = $this->findById($id);

        if ($user) {
            return $user->delete();
        }

        return false;
    }
}
