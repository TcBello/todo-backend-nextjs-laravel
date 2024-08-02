<?php

namespace App\Services;

use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Collection;
use App\Models\User;

class UserService
{
    protected $userRepo;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepo = $userRepository;
    }

    public function findAll(): Collection
    {
        return $this->userRepo->findAll();
    }

    public function findById(int $id): ?User
    {
        return $this->userRepo->findById($id);
    }

    public function create(array $data): User
    {
        return $this->create($data);
    }

    public function update(string $id, array $data): ?User
    {
        return $this->userRepo->update($id, $data);
    }

    public function delete(string $id): bool
    {
        return $this->userRepo->delete($id);
    }
}
