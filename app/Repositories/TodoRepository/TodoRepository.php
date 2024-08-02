<?php

namespace App\Repositories\TodoRepository;

use App\Repositories\TodoRepository\BaseTodoRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Support\Collection;
use App\Models\Todo;

class TodoRepository implements BaseTodoRepository
{

    public function findAll(): Collection
    {
        return Todo::all();
    }

    public function findById(string $id): ?Todo
    {
        return Todo::find($id);
    }

    public function create(array $data): Todo
    {
        return Todo::create($data);
    }

    public function update(string $id, array $data): ?Todo
    {
        $todo = $this->findById($id);

        if ($todo) {
            $todo->update($data);
            return $todo;
        }

        return null;
    }

    public function delete(string $id): bool
    {
        $todo = $this->findById($id);

        if ($todo) {
            return $todo->delete();
        }

        return false;
    }

    public function findAllByUserId(string $userId): ?Collection
    {
        $userRepo = new UserRepository();

        $user = $userRepo->findById($userId);

        if ($user) {
            $todos = $user->todos;
            return $todos;
        }

        return null;
    }
}
