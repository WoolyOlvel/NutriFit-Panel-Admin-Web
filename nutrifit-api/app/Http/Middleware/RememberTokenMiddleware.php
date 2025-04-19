<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RememberTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];

            $user = User::where('remember_token', $token)
                ->where('remember_token_expires_at', '>', now())
                ->first();

            if ($user) {
                Auth::login($user, true);
            }
        }

        return $next($request);
    }
}
