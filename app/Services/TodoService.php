<?php

namespace App\Services;

use App\Models\Todo;
use App\Repositories\TodoRepository\TodoRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Collection;

class TodoService
{
    protected $todoRepo;

    public function __construct(TodoRepository $todoRepo)
    {
        $this->todoRepo = $todoRepo;
    }

    public function findAll(): Collection
    {
        return $this->todoRepo->findAll();
    }

    public function findById($id): ?Todo
    {
        return $this->todoRepo->findById($id);
    }

    public function create(array $data): Todo
    {
        return $this->todoRepo->create($data);
    }

    public function update(string $id, array $data): Todo
    {
        return $this->todoRepo->update($id, $data);
    }

    /**
     * Delete Todo
     */
    public function delete(string $id): bool
    {
        return $this->todoRepo->delete($id);
    }

    public function findAllByUserId(string $userId): ?Collection
    {
        return $this->todoRepo->findAllByUserId($userId);
    }
}
