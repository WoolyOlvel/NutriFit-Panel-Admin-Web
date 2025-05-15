<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class registerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'usuario' => 'required|string|max:255|unique:users,usuario',
            'password' => 'required|string|min:8',
            'rol_id' => 'sometimes|integer', // Opcional: si no viene, se asigna un valor por defecto
        ]);

        $user = User::create([
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'usuario' => $request->usuario,
            'password' => Hash::make($request->password),
            'rol_id' => $request->input('rol_id', 1), // Si no viene rol_id, usa 1 (nutriólogo)
            'activo' => 1,
            'eliminado' => 0,
        ]);

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'user' => $user,
        ], 201);
    }




}
