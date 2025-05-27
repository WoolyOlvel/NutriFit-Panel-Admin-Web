<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tipo_Consulta;

class TipoConsultaController extends Controller
{
    public function index()
    {
        try {
            $tiposConsulta = Tipo_Consulta::select([
                'Tipo_Consulta_ID',
                'Nombre',
                'Precio',
                'Duracion',
                'total_pago'
            ])->get();

            return response()->json([
                'success' => true,
                'data' => $tiposConsulta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener los tipos de consulta'
            ], 500);
        }
    }
}
