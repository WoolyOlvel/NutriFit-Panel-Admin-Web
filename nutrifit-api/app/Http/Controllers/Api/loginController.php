<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str; // arriba del archivo
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'nullable|boolean',
            'is_mobile' => 'nullable|boolean', // Campo opcional
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'El correo no está registrado.'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Contraseña incorrecta.'], 401);
        }

        // Determinar si es móvil (true si existe y es true, false en cualquier otro caso)
        $isMobile = filter_var($request->is_mobile, FILTER_VALIDATE_BOOLEAN);

        // Lógica de verificación de roles
        if ($isMobile && $user->rol_id !== 2) {
            return response()->json(['error' => 'Acceso solo para pacientes en la app móvil.'], 403);
        }

        if (!$isMobile && $user->rol_id !== 1) {
            return response()->json(['error' => 'Acceso solo para nutriólogos en la web.'], 403);
        }

        // Generar token de sesión (puedes usar JWT, aquí lo hacemos manual)
        $rememberToken = null;
        if ($request->remember) {
            $rememberToken = Str::random(60);
            $user->remember_token = $rememberToken;

            // Establecer la fecha de expiración del remember_token
            $user->remember_token_expires_at = now()->addDays(30);
            $user->save();
        }
        $user->load('role');

        return response()->json([
            'message' => 'Login exitoso',
            'user' => $user->toArray(),
            'remember_token' => $rememberToken, // <-- importante
        ]);
    }

    public function autoLogin(Request $request)
    {
        $token = $request->header('remember-token'); // también podrías usar una cookie si estás en navegador

        $user = User::where('remember_token', $token)
            ->where('remember_token_expires_at', '>', now()) // Verifica expiración
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Token inválido o expirado.'], 401);
        }



        $user->load('role');

        return response()->json([
            'message' => 'Autologin exitoso',
            'user' => $user->toArray(),
        ]);
    }


    public function logout(Request $request)
    {
        $token = $request->header('remember-token') ?? $_COOKIE['remember_token'] ?? null;

        if ($token) {
            $user = User::where('remember_token', $token)->first();

            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
        }

        // Borrar cookie del navegador
        return response()->json(['message' => 'Sesión cerrada correctamente'])
            ->cookie('remember_token', '', -1, '/'); // Esto borra la cookie
    }


}

