<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estatura;
use Illuminate\Support\Facades\Validator;

class estaturaController extends Controller
{
    //
    public function listar()
    {
        $estatura = Estatura::where('estado', 1)->get(); // Solo activos
        return response()->json([
            'data' => $estatura
        ]);
    }

    public function guardar_editar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->filled('Estatura_ID')) {
            // Editar
            $estatura = Estatura::find($request->Estatura_ID);
            if (!$estatura) {
                return response()->json(['status' => 'error', 'message' => 'Estatura no encontrado'], 404);
            }
        } else {
            // Crear
            $estatura = new Estatura();
            $estatura->estado = 1; // Por defecto activa
            $estatura->fecha_creacion = now();
        }

        $estatura->nombre = $request->nombre;
        $estatura->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Estatura guardada/actualizada correctamente',
            'data' => $estatura
        ]);
    }

    public function mostrar(Request $request)
    {
        $estatura = Estatura::find($request->Estatura_ID);
        if (!$estatura) {
            return response()->json(['status' => 'error', 'message' => 'Estatura no encontrado'], 404);
        }
        return response()->json($estatura);
    }

    public function eliminar(Request $request)
    {
        $estatura = Estatura::find($request->Estatura_ID);
        if (!$estatura) {
            return response()->json(['status' => 'error', 'message' => 'Estatura no encontrado'], 404);
        }

        $estatura->estado = 0; // Cambiar estado a inactivo
        $estatura->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Estatura eliminada correctamente'
        ]);
    }


}
