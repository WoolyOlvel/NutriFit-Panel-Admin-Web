<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ComposicionCorporal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class composicionCorporalController extends Controller
{
    //

    public function listar(){
        $composicionCorporal = ComposicionCorporal::where('estado', 1)->get(); // Solo activos
        return response()->json([
            'data' => $composicionCorporal
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

        if ($request->filled('ComposicionCorporal_ID')) {
            // Editar
            $composicionCorporal = ComposicionCorporal::find($request->ComposicionCorporal_ID);
            if (!$composicionCorporal) {
                return response()->json(['status' => 'error', 'message' => 'Composición Corporal no encontrado'], 404);
            }
        } else {
            // Crear
            $composicionCorporal = new ComposicionCorporal();
            $composicionCorporal->estado = 1; // Por defecto activa
            $composicionCorporal->fecha_creacion = now();
        }

        $composicionCorporal->nombre = $request->nombre;
        $composicionCorporal->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Composición Corporal guardada/actualizada correctamente',
            'data' => $composicionCorporal
        ]);
    }

    public function mostrar(Request $request)
    {
        $composicionCorporal = ComposicionCorporal::find($request->ComposicionCorporal_ID);
        if (!$composicionCorporal) {
            return response()->json(['status' => 'error', 'message' => 'Composición Corporal no encontrado'], 404);
        }

        return response()->json($composicionCorporal);
    }

    public function eliminar(Request $request)
    {
        $composicionCorporal = ComposicionCorporal::find($request->ComposicionCorporal_ID);
        if (!$composicionCorporal) {
            return response()->json(['status' => 'error', 'message' => 'Composición Corporal no encontrado'], 404);
        }

        $composicionCorporal->estado = 0; // Cambiar estado a inactivo
        $composicionCorporal->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Composición Corporal eliminada correctamente'
        ]);
    }



}
