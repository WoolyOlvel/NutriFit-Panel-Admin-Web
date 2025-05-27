<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NutriDesafios;

class NutriDesafiosMovilController extends Controller
{
    public function index()
    {
        $desafios = NutriDesafios::where('estado', 1)
            ->orderBy('tipo')
            ->orderBy('fecha_creacion', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $desafios
        ]);
    }
}
