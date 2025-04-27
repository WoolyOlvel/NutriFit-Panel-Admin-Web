<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MedidasCorporales;
use Illuminate\Support\Facades\Validator;

class medidasCorporalesController extends Controller
{
    //

    public function listar()
    {
        $medidas_corporales = MedidasCorporales::where('estado', 1)->get(); // Solo activos

        return response()->json([
            'data' => $medidas_corporales
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

        if ($request->filled('MedidasCorporales_ID')) {
            // Editar
            $medidas_corporales = MedidasCorporales::find($request->MedidasCorporales_ID);
            if (!$medidas_corporales) {
                return response()->json(['status' => 'error', 'message' => 'Medidas Corporales no encontrado'], 404);
            }
        } else {
            // Crear
            $medidas_corporales = new MedidasCorporales();
            $medidas_corporales->estado = 1; // Por defecto activa
            $medidas_corporales->fecha_creacion = now();
        }

        $medidas_corporales->nombre = $request->nombre;
        $medidas_corporales->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Medidas Corporales guardada/actualizada correctamente',
            'data' => $medidas_corporales
        ]);
    }

    public function mostrar(Request $request)
    {
        $medidas_corporales = MedidasCorporales::find($request->MedidasCorporales_ID);
        if (!$medidas_corporales) {
            return response()->json(['status' => 'error', 'message' => 'Medidas Corporales no encontrado'], 404);
        }

        return response()->json($medidas_corporales);
    }

    public function eliminar(Request $request)
    {
        $medidas_corporales = MedidasCorporales::find($request->MedidasCorporales_ID);
        if (!$medidas_corporales) {
            return response()->json(['status' => 'error', 'message' => 'Medidas Corporales no encontrado'], 404);
        }

        $medidas_corporales->estado = 0; // Cambiar estado a inactivo
        $medidas_corporales->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Medidas Corporales eliminada correctamente'
        ]);
    }

}
