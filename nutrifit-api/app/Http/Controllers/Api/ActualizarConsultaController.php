<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Divisas;
use App\Models\Pago;
use App\Models\Tipo_Consulta;
use App\Models\User;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;
use App\Models\Consulta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActualizarConsultaController extends Controller
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

    public function obtenerConsulta(Request $request, $consultaId)
    {
        // Obtener el usuario autenticado usando el remember_token
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        try {
            // Buscar la consulta por ID
            $consulta = Consulta::where('Consulta_ID', $consultaId)->first();

            if (!$consulta) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Consulta no encontrada'
                ], 404);
            }

            // Verificar que la consulta pertenezca al usuario actual
            if ($consulta->user_id != $user->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No tienes autorización para ver esta consulta'
                ], 403);
            }

            // Procesar los archivos adjuntos (si existen)
            $archivos = [];
            if ($consulta->plan_nutricional_path) {
                $rutas = json_decode($consulta->plan_nutricional_path, true);
                if (is_array($rutas)) {
                    foreach ($rutas as $index => $ruta) {
                        // Extraer nombre del archivo de la URL
                        $nombreArchivo = basename($ruta);
                        $urlCompleta = $ruta; // URL completa para acceder al archivo

                        $archivos[] = [
                            'nombre' => $nombreArchivo,
                            'url' => $urlCompleta,
                            'index' => $index
                        ];
                    }
                }
            }

            // Datos completos de la consulta
            $datosConsulta = $consulta->toArray();
            $datosConsulta['archivos'] = $archivos;

            return response()->json([
                'status' => 'success',
                'data' => $datosConsulta
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al obtener consulta: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener los datos de la consulta',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar los datos de una consulta existente
     */
    public function actualizarConsulta(Request $request, $consultaId)
    {
        // Obtener el usuario autenticado
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Buscar la consulta existente
        $consulta = Consulta::where('Consulta_ID', $consultaId)->first();

        if (!$consulta) {
            return response()->json([
                'status' => 'error',
                'message' => 'Consulta no encontrada'
            ], 404);
        }

        // Verificar que la consulta pertenezca al usuario actual
        if ($consulta->user_id != $user->id) {
            return response()->json([
                'status' => 'error',
                'message' => 'No tienes autorización para modificar esta consulta'
            ], 403);
        }

        // Validación de datos
        $validationRules = [
            'Paciente_ID' => 'required|exists:paciente,Paciente_ID',
            'Tipo_Consulta_ID' => 'required|exists:tipo_consulta,Tipo_Consulta_ID',
            'Documento_ID' => 'required|exists:documento,Documento_ID',
            'Pago_ID' => 'required|exists:pago,Pago_ID',
            'Divisa_ID' => 'required|exists:divisas,Divisa_ID',
            'peso' => 'nullable|numeric|between:0,999.99',
            'talla' => 'nullable|string',
            'cintura' => 'nullable|numeric|between:0,999.99',
            'cadera' => 'nullable|numeric|between:0,999.99',
            'gc' => 'nullable|numeric|between:0,999.99',
            'mm' => 'nullable|numeric|between:0,999.99',
            'em' => 'nullable|numeric|between:0,999.99',
            'altura' => 'nullable|numeric|between:0,999.99',
            'detalles_diagnostico' => 'nullable|string',
            'resultados_evaluacion' => 'nullable|string',
            'analisis_nutricional' => 'nullable|string',
            'objetivo_descripcion' => 'nullable|string',
            'proxima_consulta' => 'nullable|date_format:Y-m-d H:i:s',
            'nombre_consultorio' => 'nullable|string',
            'direccion_consultorio' => 'nullable|string',
            'total_archivos_nuevos' => 'nullable|integer|min:0|max:10',
            'archivos_existentes' => 'nullable|string',
        ];

        // Agregar reglas de validación para cada archivo nuevo
        $totalArchivosNuevos = $request->input('total_archivos_nuevos', 0);
        for ($i = 0; $i < $totalArchivosNuevos; $i++) {
            $validationRules["plan_nutricional_path_{$i}"] = 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:15500';
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'Paciente_ID.exists' => 'El paciente seleccionado no existe',
            'Tipo_Consulta_ID.exists' => 'El tipo de consulta seleccionado no existe',
            'Documento_ID.exists' => 'El documento seleccionado no existe',
            'Pago_ID.exists' => 'El tipo de pago seleccionado no existe',
            'Divisa_ID.exists' => 'La divisa seleccionada no existe',
            'numeric' => 'El campo :attribute debe ser un número',
            'between' => 'El campo :attribute debe estar entre :min y :max',
            'mimes' => 'El archivo debe ser PDF, DOC, DOCX, JPG, JPEG o PNG',
            'max' => 'El archivo no debe exceder 15MB'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtener datos del paciente
            $paciente = Paciente::where('Paciente_ID', $request->Paciente_ID)->first();
            if (!$paciente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            // Actualizar datos básicos de la consulta
            $consulta->fill($request->only([
                'Paciente_ID',
                'Tipo_Consulta_ID',
                'Documento_ID',
                'Pago_ID',
                'Divisa_ID',
                'edad',
                'fecha_nacimiento',
                'localidad',
                'ciudad',
                'peso',
                'talla',
                'cintura',
                'cadera',
                'gc',
                'mm',
                'em',
                'altura',
                'detalles_diagnostico',
                'resultados_evaluacion',
                'analisis_nutricional',
                'objetivo_descripcion',
                'nombre_consultorio',
                'direccion_consultorio'
            ]));

            // Normalizar talla
            $consulta->talla = $this->normalizarTalla($request->talla);

            // Procesar archivos
            $archivosPrevios = [];
            $archivosAnteriores = json_decode($consulta->plan_nutricional_path, true) ?: [];

            // Procesar archivos existentes a mantener
            if ($request->archivos_existentes) {
                $archivosAMantener = explode(',', $request->archivos_existentes);
                foreach ($archivosAMantener as $nombreArchivo) {
                    $nombreArchivo = trim($nombreArchivo);
                    foreach ($archivosAnteriores as $archivo) {
                        if (str_contains($archivo, $nombreArchivo)) {
                            $archivosPrevios[] = $archivo;
                            break;
                        }
                    }
                }
            }

            // Eliminar archivos no mantenidos
            $this->eliminarArchivosNoMantenidos($consulta, $paciente, $archivosPrevios, $archivosAnteriores);

            // Procesar archivos nuevos
            $plan_nutricional_urls = $archivosPrevios;
            $nombreCarpetaPaciente = Str::slug($paciente->nombre . '+' . $paciente->apellidos);
            $carpetaConsulta = 'plan_nutricional/' . $nombreCarpetaPaciente . '/' . $consulta->Consulta_ID;

            if (!Storage::disk('public')->exists($carpetaConsulta)) {
                Storage::disk('public')->makeDirectory($carpetaConsulta, 0755, true);
            }

            for ($i = 0; $i < $totalArchivosNuevos; $i++) {
                $fileInputName = "plan_nutricional_path_{$i}";

                if ($request->hasFile($fileInputName)) {
                    $file = $request->file($fileInputName);

                    if ($file->isValid()) {
                        $extension = strtolower($file->getClientOriginalExtension());
                        $originalName = $file->getClientOriginalName();
                        $safeOriginalName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
                        $uniqueFilename = $consulta->Consulta_ID . '_' . time() . '_' . $i . '_' . $safeOriginalName . '.' . $extension;

                        $path = $file->storeAs($carpetaConsulta, $uniqueFilename, 'public');

                        if ($path) {
                            $plan_nutricional_urls[] = asset('storage/' . $path);
                        }
                    }
                }
            }

            // Actualizar archivos en la consulta
            $consulta->plan_nutricional_path = !empty($plan_nutricional_urls) ? json_encode($plan_nutricional_urls) : null;

            // Actualizar fecha de próxima consulta si se proporciona
            if ($request->proxima_consulta) {
                $consulta->proxima_consulta = $request->proxima_consulta;
            }

            // Recalcular total del pago
            $tipoConsulta = Tipo_Consulta::find($request->Tipo_Consulta_ID);
            $divisa = Divisas::find($request->Divisa_ID);

            if ($tipoConsulta && $divisa) {
                $precioMXN = $tipoConsulta->Precio;
                $consulta->total_pago = $precioMXN / $divisa->tasa_cambio;
            }

            // Guardar cambios
            $consulta->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Consulta actualizada correctamente',
                'data' => $consulta
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al actualizar la consulta',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    private function eliminarArchivosNoMantenidos($consulta, $paciente, $archivosPrevios, $archivosAnteriores)
    {
        if (empty($archivosPrevios)) {
            // Eliminar todos los archivos anteriores si no se mantiene ninguno
            $nombreCarpetaPaciente = Str::slug($paciente->nombre . '+' . $paciente->apellidos);
            $carpetaConsulta = 'plan_nutricional/' . $nombreCarpetaPaciente . '/' . $consulta->Consulta_ID;

            if (Storage::disk('public')->exists($carpetaConsulta)) {
                Storage::disk('public')->deleteDirectory($carpetaConsulta);
            }
        } else {
            // Eliminar solo los archivos que no se están manteniendo
            foreach ($archivosAnteriores as $archivo) {
                $mantener = false;
                foreach ($archivosPrevios as $mantenido) {
                    if ($mantenido === $archivo) {
                        $mantener = true;
                        break;
                    }
                }

                if (!$mantener) {
                    $rutaArchivo = str_replace(asset('storage/'), '', $archivo);
                    if (Storage::disk('public')->exists($rutaArchivo)) {
                        Storage::disk('public')->delete($rutaArchivo);
                    }
                }
            }
        }
    }

    // Normalizar talla (mismo método que en ConsultaController)
    private function normalizarTalla($talla)
    {
        if (!$talla) return null;

        $tallaLower = strtolower(trim($talla));
        $mappingTallas = [
            'chico' => 'CH',
            'chica' => 'CH',
            'pequeño' => 'CH',
            'pequeña' => 'CH',
            'mediano' => 'M',
            'mediana' => 'M',
            'medio' => 'M',
            'media' => 'M',
            'grande' => 'G',
            'gran' => 'G',
            'extra grande' => 'XG',
            'extragrande' => 'XG',
            'extra-grande' => 'XG',
            'xl' => 'XG',
            'extra chico' => 'XCH',
            'extrachico' => 'XCH',
            'extra-chico' => 'XCH',
            'xs' => 'XCH',
            'xxl' => 'XXG',
            'extra extra grande' => 'XXG',
            'doble extra grande' => 'XXG',
        ];

        foreach ($mappingTallas as $nombre => $abreviatura) {
            if (strpos($tallaLower, $nombre) !== false) {
                return $abreviatura;
            }
        }

        $abreviaturas = ['CH', 'M', 'G', 'XG', 'XCH', 'XXG'];
        $tallaUpper = strtoupper($talla);
        if (in_array($tallaUpper, $abreviaturas)) {
            return $tallaUpper;
        }

        return $talla;
    }
}
