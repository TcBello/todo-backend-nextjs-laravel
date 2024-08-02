<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "email" => "required|string",
                "password" => "required|string"
            ]);

            if ($this->authService->attempt($validatedData)) {
                $existingUser = Auth::user();

                $token = $existingUser->createToken("access-token")->accessToken;

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

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::create($validatedData);

        $token = $user->createToken('access-token')->accessToken;

        $data = ['message' => 'User registered', 'data' => $user, 'token' => $token];

        return response()->json($data, 201);
    }

    public function logout()
    {
        $this->authService->revokeToken();

        return response()->json(["message" => "User logged out"], 200);
    }

    public function refreshToken(Request $request)
    {
        $user = Auth::user();

        $token = $user->createToken("access-token")->accessToken;

        $data = ["message" => "Refreshed Token", "data" => $token];

        return response()->json($data, 200);
    }

    public function currentUser()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        $data = ["message" => "User found", "data" => $user];

        return response()->json($data, 200);
    }
}
