<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function index()
    {
        return "auth route";
    }

    /**
     * Login method for user
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $requestBody = $request->json()->all();

            if ($this->authService->attempt($requestBody)) {
                $existingUser = $this->authService->user();

                $token = $this->authService->createToken();

                $data = [
                    "message" => "User logged in",
                    "data" => $existingUser,
                    'status' => 'ok',
                    "token" => $token
                ];

                return response()->json($data, 200);
            } else {
                return response()->json([
                    "status" => "error",
                    "message" => "Invalid credentials"
                ], 401);
            }
        } catch (Exception $e) {
            return response()->json([
                "status" => "error",
                "message"=> $e->getMessage()
            ], 500);
        }
    }

    /**
     * Register method for user
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $requestData = $request->json()->all();

            $user = $this->authService->register($requestData);

            if (!$user) {
                $data = ["status" => "error", "message" => "User registration failed"];
                return response()->json($data, 400);
            }

            $token = $user->createToken('access-token')->accessToken;

            $data = ['message' => 'User registered', 'data' => $user, 'status' => 'ok', 'token' => $token];

            return response()->json($data, 201);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout method for user
     */
    public function logout(): JsonResponse
    {
        try {
            $isLoggedOut = $this->authService->revokeToken();

            if (!$isLoggedOut) {
                $data = ['status' => 'error', 'message' => 'Logout failed'];
                return response()->json($data, 400);
            }

            return response()->json(["message" => "User logged out", 'status' => 'ok',], 200);
        } catch (Exception $e) {
            return response()->json([
                'status'=> 'error',
                'message'=> $e->getMessage()
            ], 500);
        }
    }

    /**
     * Refreshes the token of the user
     */
    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $user = $this->authService->user();

            $token = $user->createToken("access-token")->accessToken;

            $data = ["message" => "Refreshed Token", 'status' => 'ok', "data" => $token];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> "error",
                "message"=> $e->getMessage()
            ]. 500);
        }
    }

    /**
     * Fetch the user data of the current logged in user
     */
    public function currentUser(): JsonResponse
    {
        try {
            $user = $this->authService->user();

            if (!$user) {
                return response()->json(["status" => "error", "message" => "User not found"], 404);
            }

            $data = ["message" => "User found", 'status' => 'ok', "data" => $user];

            return response()->json($data, 200);
        } catch (Exception $e) {
            return response()->json([
                "status"=> "error",
                "message"=> $e->getMessage()
            ], 500);
        }
    }
}
