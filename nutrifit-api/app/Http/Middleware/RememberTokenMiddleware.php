<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RememberTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        $token = $request->header('remember-token');

        $user = User::where('remember_token', $token)
            ->where('remember_token_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json(['error' => 'No autenticado'], 401);
        }

        // Hacer que auth()->user() funcione
        Auth::login($user);

        return $next($request);
    }
}
