<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Talla;
use Illuminate\Support\Facades\Validator;

class TallaController extends Controller
{
    public function listar()
    {
        $tallas = Talla::where('estado', 1)->get(); // Solo activos

        return response()->json([
            'data' => $tallas
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

        if ($request->filled('Talla_ID')) {
            // Editar
            $talla = Talla::find($request->Talla_ID);
            if (!$talla) {
                return response()->json(['status' => 'error', 'message' => 'Talla no encontrada'], 404);
            }
        } else {
            // Crear
            $talla = new Talla();
            $talla->estado = 1; // Por defecto activa
            $talla->fecha_creacion = now();
        }

        $talla->nombre = $request->nombre;
        $talla->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Talla guardada/actualizada correctamente',
            'data' => $talla
        ]);
    }

    public function mostrar(Request $request)
    {
        $talla = Talla::find($request->Talla_ID);

        if (!$talla) {
            return response()->json(['status' => 'error', 'message' => 'Talla no encontrada'], 404);
        }

        return response()->json($talla);
    }

    public function eliminar(Request $request)
    {
        $talla = Talla::find($request->Talla_ID);

        if (!$talla) {
            return response()->json(['status' => 'error', 'message' => 'Talla no encontrada'], 404);
        }

        $talla->estado = 0; // Marcar como "eliminado"
        $talla->save();

        return response()->json(['status' => 'success', 'message' => 'Talla eliminada (estado=0)']);
    }
}
