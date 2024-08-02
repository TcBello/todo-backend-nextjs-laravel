<?php

namespace App\Providers;

use App\Repositories\AuthRepository\AuthRepository;
use App\Repositories\AuthRepository\BaseAuthRepository;
use App\Repositories\TodoRepository\BaseTodoRepository;
use App\Repositories\TodoRepository\TodoRepository;
use App\Repositories\UserRepository\BaseUserRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseTodoRepository::class, TodoRepository::class);
        $this->app->bind(BaseUserRepository::class, UserRepository::class);
        $this->app->bind(BaseAuthRepository::class, AuthRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });
    }
}
