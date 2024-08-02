<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
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
     * @param \App\Http\Requests\Auth\LoginUserRequest $request
     */
    public function login(LoginUserRequest $request)
    {
        try {
            $requestBody = $request->json()->all();

            if ($this->authService->attempt($requestBody)) {
                $existingUser = $this->authService->user();

                $token = $this->authService->createToken();

                $data = [
                    "message" => "User logged in",
                    "data" => $existingUser,
                    "token" => $token
                ];

                return response()->json($data, 200);
            } else {
                return response()->json([
                    "message" => "Invalid credentials"
                ], 401);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Register method for user
     * @param \App\Http\Requests\Auth\RegisterUserRequest $request
     */
    public function register(RegisterUserRequest $request)
    {
        $requestData = $request->json()->all();

        $user = $this->authService->register($requestData);

        $token = $user->createToken('access-token')->accessToken;

        $data = ['message' => 'User registered', 'data' => $user, 'token' => $token];

        return response()->json($data, 201);
    }

    /**
     * Logout method for user
     */
    public function logout()
    {
        $this->authService->revokeToken();

        return response()->json(["message" => "User logged out"], 200);
    }

    /**
     * Refreshes the token of the user
     * @param \Illuminate\Http\Request $request
     */
    public function refreshToken(Request $request)
    {
        $user = $this->authService->user();

        $token = $user->createToken("access-token")->accessToken;

        $data = ["message" => "Refreshed Token", "data" => $token];

        return response()->json($data, 200);
    }

    /**
     * Fetch the user data of the current logged in user
     */
    public function currentUser()
    {
        $user = $this->authService->user();

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        $data = ["message" => "User found", "data" => $user];

        return response()->json($data, 200);
    }
}
