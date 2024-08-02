<?php

namespace App\Repositories\TodoRepository;

use App\Models\Todo;
use Illuminate\Support\Collection;

interface BaseTodoRepository
{
    public function findAll(): Collection;
    public function findById(string $id): ?Todo;
    public function create(array $data): Todo;
    public function update(string $id, array $data): ?Todo;
    public function delete(string $id): bool;

    public function findAllByUserId(string $userId): ?Collection;
}
