<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TodoService;

class TodoController extends Controller
{
    protected $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();

        return response()->json($todos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "user_id" => "required|numeric",
            "content" => "required|string",
        ]);

        $todo = $this->todoService->create($validatedData);

        $data = ['message' => 'Todo created', 'data' => $todo, 'requestData' => $request];

        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $todo = $this->todoService->findById($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $data = ['message' => 'Todo found', 'data' => $todo];

        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $todo = $this->todoService->findById($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $validatedData = $request->validate([
            'content' => 'string',
        ]);

        // $todo->update($validatedData);
        $todo = $this->todoService->update($todo->id, $validatedData, );

        $data = ['message' => 'Todo updated', 'data' => $todo];

        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = $this->todoService->findById($id);

        if (!$todo) {
            return response()->json(['message' => 'Todo not found'], 404);
        }

        $this->todoService->delete($todo->id);

        return response()->json(['message' => 'Todo deleted'], 200);
    }

    public function fetchTodosByUserId(string $id)
    {
        $todos = $this->todoService->findAllByUserId($id);

        return response()->json($todos, 200);
    }
}
