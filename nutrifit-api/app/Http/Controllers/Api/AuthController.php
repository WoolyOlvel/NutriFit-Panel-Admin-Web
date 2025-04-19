<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function handleRequest()
    {
        // Verificar si existe la cookie de remember_token
        if (isset($_COOKIE['remember_token'])) {
            $token = $_COOKIE['remember_token'];

            // Buscar al usuario que tiene este token
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                // Iniciar sesión automáticamente
                Auth::login($user, true);
                return redirect()->to('/home');
            }
        }

        // Si no existe el token o no es válido, redirigir a login
        return redirect()->route('login');
    }
}

