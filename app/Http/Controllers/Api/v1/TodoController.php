<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Todo\CreateTodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\TodoService;
use Exception;

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
    public function index(): JsonResponse
    {
        try {
            $todos = $this->todoService->findAll();

            $data = [
                "message" => "Successfuly fetched",
                "status" => "ok",
                "data"=> $todos
            ];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> "error",
                "message"=> $e->getMessage()
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTodoRequest $request): JsonResponse
    {
        try {
            $requestData = $request->json()->all();

            $todo = $this->todoService->create($requestData);

            if (!$todo) {
                $data = ['message' => 'Creation failed', 'status' => 'error'];

                return response()->json($data, 400);
            }

            $data = ['message' => 'Todo created', 'status' => 'ok', 'data' => $todo];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        try {
            $todo = $this->todoService->findById($id);

            if (!$todo) {
                return response()->json(['message' => 'Todo not found', 'status' => 'error'], 404);
            }

            $data = ['message' => 'Todo found', 'status' => 'ok', 'data' => $todo];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id): JsonResponse
    {
        try {
            $todo = $this->todoService->findById($id);

            if (!$todo) {
                return response()->json(['message' => 'Todo not found', 'status' => 'error'], 404);
            }

            $requestData = $request->json()->all();

            $todo = $this->todoService->update($todo->id, $requestData);

            $data = ['message' => 'Todo updated', 'status' => 'ok', 'data' => $todo];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ]. 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $todo = $this->todoService->findById($id);

            if (!$todo) {
                return response()->json(['message' => 'Todo not found', 'status' => 'error'], 404);
            }

            $isDeleted = $this->todoService->delete($todo->id);

            if (!$isDeleted) {
                return response()->json(['message' => 'Deletion failed', 'status' => "error"], 400);
            }

            return response()->json(['message' => 'Todo deleted', 'status' => 'ok',], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ],500);
        }
    }

    public function fetchTodosByUserId(string $id): JsonResponse
    {
        try {
            $todos = $this->todoService->findAllByUserId($id);

            if ($todos == null) {
                return response()->json(['message' => 'Failed fetch data', 'status' => 'error'], 400);
            }

            $data = ['message' => "Todos found", "status" => "ok", "data" => $todos];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> "error",
                "message"=> $e->getMessage()
            ],500);
        }
    }
}
