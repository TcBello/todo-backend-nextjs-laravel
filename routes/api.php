<?php

use App\Http\Controllers\Api\v1\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\TodoController;

$apiVersion = "v1";

// AUTH ROUTES
Route::post("/{$apiVersion}/login", [AuthController::class, 'login'])->name('login');
Route::post("/{$apiVersion}/register", [AuthController::class, 'register'])->name('register');

// PROTECTED ROUTES
Route::group(["middleware" => ['auth:api']], function () {
    $apiVersion = "v1";

    Route::get("/{$apiVersion}/logout", [AuthController::class, 'logout'])->name('logout');
    Route::post("/{$apiVersion}/refresh-token", [AuthController::class, 'refreshToken'])->name('refresh-token');
    Route::get("/{$apiVersion}/current-user", [AuthController::class, 'currentUser'])->name('current-user');

    // TODO ROUTES
    Route::apiResource("$apiVersion/todos", TodoController::class);
});

// USER ROUTES
Route::apiResource("$apiVersion/users", UserController::class);
Route::get("/{$apiVersion}/users/{id}/todos", [TodoController::class, "fetchTodosByUserId"])->name("users-todo");
