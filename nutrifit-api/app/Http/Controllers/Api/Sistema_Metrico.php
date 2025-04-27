<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SistemaMetrico;
use Illuminate\Support\Facades\Validator;

class Sistema_Metrico extends Controller
{
    //

    public function listar()
    {
        $sistema_metrico = SistemaMetrico::where('estado', 1)->get(); // Solo activos

        return response()->json([
            'data' => $sistema_metrico
        ]);
    }

    public function guardar_editar(Request $request){
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->filled('SistemaMetrico_ID')) {
            // Editar
            $sistema_metrico = SistemaMetrico::find($request->SistemaMetrico_ID);
            if (!$sistema_metrico) {
                return response()->json(['status' => 'error', 'message' => 'Sistema Metrico no encontrado'], 404);
            }
        } else {
            // Crear
            $sistema_metrico = new SistemaMetrico();
            $sistema_metrico->estado = 1; // Por defecto activa
            $sistema_metrico->fecha_creacion = now();
        }

        $sistema_metrico->nombre = $request->nombre;
        $sistema_metrico->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sistema Metrico guardada/actualizada correctamente',
            'data' => $sistema_metrico
        ]);
    }

    public function mostrar(Request $request)
    {
        $sistema_metrico = SistemaMetrico::find($request->SistemaMetrico_ID);
        if (!$sistema_metrico) {
            return response()->json(['status' => 'error', 'message' => 'Sistema Metrico no encontrado'], 404);
        }

        return response()->json($sistema_metrico);
    }

    public function eliminar(Request $request)
    {
        $sistema_metrico = SistemaMetrico::find($request->SistemaMetrico_ID);
        if (!$sistema_metrico) {
            return response()->json(['status' => 'error', 'message' => 'Sistema Metrico no encontrado'], 404);
        }

        $sistema_metrico->estado = 0; // Cambiar estado a inactivo
        $sistema_metrico->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Sistema Metrico eliminado correctamente'
        ]);
    }

}
