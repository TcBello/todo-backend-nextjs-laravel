<?php

namespace App\Repositories\UserRepository;

use Illuminate\Support\Collection;
use App\Models\User;

interface BaseUserRepository
{
    public function findAll(): Collection;
    public function findById(int $id): ?User;
    public function create(array $data): User;
    public function update(string $id, array $data): ?User;
    public function delete(string $id): bool;
}
