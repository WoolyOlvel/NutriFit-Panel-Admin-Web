<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NutriDesafios;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NutriDesafiosController extends Controller
{
    // Función para verificar el token y obtener el usuario
    private function getUserFromToken(Request $request)
    {
        $token = $request->header('remember-token');
        if (!$token) {
            return null;
        }

        return User::where('remember_token', $token)
            ->where('remember_token_expires_at', '>', now())
            ->first();
    }

    // Método para listar desafíos
    public function index(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Obtenemos solo los desafíos activos (estado = 1) relacionados con este usuario
        $desafios = NutriDesafios::where('user_id', $user->id)
                                ->where('estado', 1)
                                ->get();

        return response()->json([
            'status' => 'success',
            'data' => $desafios
        ]);
    }

    // Alias para index
    public function listar(Request $request)
    {
        return $this->index($request);
    }

    // Método combinado para guardar o editar
    public function guardar_editar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Determinar si es creación o actualización
        if ($request->has('id') && !empty($request->id)) {
            return $this->actualizar($request, $user);
        } else {
            return $this->crear($request, $user);
        }
    }

    // Método para mostrar un desafío específico
    public function mostrar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'NutriDesafios_ID' => 'required|integer' // Cambiado a NutriDesafios_ID
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $desafio = NutriDesafios::where('NutriDesafios_ID', $request->NutriDesafios_ID)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$desafio) {
            return response()->json([
                'status' => 'error',
                'message' => 'Desafío no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $desafio
        ]);
    }

    // Método para eliminar un desafío (borrado lógico)
     public function eliminar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'NutriDesafios_ID' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $desafio = NutriDesafios::where('NutriDesafios_ID', $request->NutriDesafios_ID)
                    ->where('user_id', $user->id)
                    ->first();

        if (!$desafio) {
            return response()->json([
                'status' => 'error',
                'message' => 'Desafío no encontrado'
            ], 404);
        }

        // Cambiar el estado a 0 en lugar de eliminar
        $desafio->estado = 0;
        $desafio->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Desafío eliminado correctamente'
        ]);
    }

    // Método interno para crear un desafío
    private function crear(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'url' => 'required|url',
            'tipo' => 'required|string|max:255',
            'status' => 'required|integer|in:0,1,2', // 0=Inactivo, 1=Activo, 2=Proximamente
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Manejar la subida de la foto
        $fotoUrl = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nombre) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('nutridesafios', $filename, 'public');
            $fotoUrl = asset('storage/' . $path);
        }

        // Crear el nuevo desafío
        $desafio = new NutriDesafios();
        $desafio->foto = $fotoUrl;
        $desafio->nombre = $request->nombre;
        $desafio->url = $request->url;
        $desafio->tipo = $request->tipo;
        $desafio->status = $request->status;
        $desafio->fecha_creacion = now();
        $desafio->user_id = $user->id;
        $desafio->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Desafío creado correctamente',
            'data' => $desafio
        ], 201);
    }

    // Método interno para actualizar un desafío
    private function actualizar(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
            'NutriDesafios_ID' => 'required|integer',
            'nombre' => 'sometimes|string|max:255',
            'url' => 'sometimes|url',
            'tipo' => 'sometimes|string|max:255',
            'status' => 'sometimes|integer|in:0,1,2',
            'foto' => 'sometimes|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $desafio = NutriDesafios::where('NutriDesafios_ID', $request->NutriDesafios_ID)
                ->where('user_id', $user->id)
                ->first();

        if (!$desafio) {
            return response()->json([
                'status' => 'error',
                'message' => 'Desafío no encontrado'
            ], 404);
        }

        // Manejar la actualización de la foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($desafio->foto && Str::startsWith($desafio->foto, asset('storage/'))) {
                $oldPath = str_replace(asset('storage/'), '', $desafio->foto);
                Storage::disk('public')->delete($oldPath);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nombre ?? $desafio->nombre) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('nutridesafios', $filename, 'public');
            $desafio->foto = asset('storage/' . $path);
        }

        // Actualizar los demás campos
        if ($request->has('nombre')) $desafio->nombre = $request->nombre;
        if ($request->has('url')) $desafio->url = $request->url;
        if ($request->has('tipo')) $desafio->tipo = $request->tipo;
        if ($request->has('status')) $desafio->status = $request->status;

        $desafio->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Desafío actualizado correctamente',
            'data' => $desafio
        ]);
    }

    // Métodos RESTful estándar
    public function store(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }
        return $this->crear($request, $user);
    }

    public function show($id, Request $request)
    {
        $request->merge(['id' => $id]);
        return $this->mostrar($request);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->guardar_editar($request);
    }

    public function destroy(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->eliminar($request);
    }


}
