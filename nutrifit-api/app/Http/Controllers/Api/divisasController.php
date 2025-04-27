<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Divisas;
use Illuminate\Support\Facades\Validator;

class divisasController extends Controller
{
    //
    public function listar(){
        $divisas = Divisas::where('estado', 1)->get(); // Solo activos
        return response()->json([
            'data' => $divisas
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

        if ($request->filled('Divisa_ID')) {
            // Editar
            $divisas = Divisas::find($request->Divisa_ID);
            if (!$divisas) {
                return response()->json(['status' => 'error', 'message' => 'Divisa no encontrado'], 404);
            }
        } else {
            // Crear
            $divisas = new Divisas();
            $divisas->estado = 1; // Por defecto activa
            $divisas->fecha_creacion = now();
        }

        $divisas->nombre = $request->nombre;
        $divisas->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisa guardada/actualizada correctamente',
            'data' => $divisas
        ]);
    }

    public function mostrar(Request $request){
        $divisas = Divisas::find($request->Divisa_ID);
        if (!$divisas) {
            return response()->json(['status' => 'error', 'message' => 'Divisa no encontrado'], 404);
        }
        return response()->json($divisas);
    }

    public function eliminar(Request $request){
        $divisas = Divisas::find($request->Divisa_ID);
        if (!$divisas) {
            return response()->json(['status' => 'error', 'message' => 'Divisa no encontrado'], 404);
        }
        $divisas->estado = 0; // Cambiar estado a inactivo
        $divisas->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Divisa eliminada correctamente'
        ]);
    }


}
