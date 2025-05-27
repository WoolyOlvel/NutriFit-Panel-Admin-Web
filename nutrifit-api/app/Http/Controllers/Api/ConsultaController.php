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

class ConsultaController extends Controller
{
    // Obtener tipos de consulta
    public function getTiposConsulta()
    {
        $tiposConsulta = Tipo_Consulta::select('Tipo_Consulta_ID', 'Nombre', 'Precio')->get();
        return response()->json($tiposConsulta);
    }

    // Obtener tipos de documento
    public function getDocumentos()
    {
        $documentos = Documento::select('Documento_ID', 'nombre')->get();
        return response()->json($documentos);
    }

    // Obtener tipos de pago
    public function getTiposPago()
    {
        $tiposPago = Pago::select('Pago_ID', 'nombre')->get();
        return response()->json($tiposPago);
    }

    // Obtener tipos de divisa
    public function getDivisas()
    {
        $divisas = Divisas::select('Divisa_ID', 'nombre', 'tasa_cambio')->get();
        return response()->json($divisas);
    }

    //Obtener pacientes
    // Obtener pacientes relacionados con el usuario logueado

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

    public function getPacientes(Request $request)
    {
        // Obtener el usuario autenticado usando el remember_token
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Obtenemos los pacientes relacionados con este usuario y que tengan estado activo (true)
        $pacientes = Paciente::where('user_id', $user->id)
            ->where('estado', true)
            ->select(
                'Paciente_ID',
                'nombre',
                'apellidos',
                'email',
                'telefono',
                'genero',
                'usuario',
                'enfermedad',
                'localidad',
                'ciudad',
                'edad',
                'fecha_nacimiento',
                'user_id'
            )
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pacientes
        ]);
    }

    // Obtener información detallada de un paciente específico
    public function getPacienteDetalle(Request $request, $id)
    {
        // Obtener el usuario autenticado usando el remember_token
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['error' => 'No autorizado'], 401);
        }

        try {
            // Busca el paciente asegurando que pertenezca al usuario actual
            $paciente = Paciente::where('Paciente_ID', $id)
                ->where('user_id', $user->id)
                ->select(
                    'Paciente_ID',
                    'nombre',
                    'apellidos',
                    'email',
                    'telefono',
                    'genero',
                    'usuario',
                    'enfermedad',
                    'localidad',
                    'ciudad',
                    'edad',
                    'fecha_nacimiento',
                    'user_id'
                )
                ->first();

            if (!$paciente) {
                return response()->json(['error' => 'Paciente no encontrado'], 404);
            }

            // Obtener el nombre del nutriólogo
            $nutriologo = \App\Models\User::where('id', $paciente->user_id)->first();
            $paciente->nutriologo_nombre = $nutriologo ? $nutriologo->nombre . ' ' . $nutriologo->apellidos : 'No asignado';

            return response()->json($paciente);
        } catch (\Exception $e) {
            // Agregar manejo de errores para debug
            Log::error('Error en getPacienteDetalle: ' . $e->getMessage());
            return response()->json(['error' => 'Error al procesar la solicitud', 'details' => $e->getMessage()], 500);
        }
    }

    public function guardarConsulta(Request $request)
    {
        // Obtener el usuario autenticado usando el remember_token
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Debug mejorado: Mostrar información sobre archivos recibidos
        $totalArchivos = $request->input('total_archivos', 0);
        $archivosRecibidos = [];

        for ($i = 0; $i < $totalArchivos; $i++) {
            $fileInputName = "plan_nutricional_path_{$i}";
            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                $archivosRecibidos[] = [
                    'nombre' => $file->getClientOriginalName(),
                    'tipo' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'tamaño' => $file->getSize()
                ];
            }
        }

        Log::info('Datos recibidos en guardarConsulta:', $request->all());
        Log::info('Archivos recibidos:', [
            'total_archivos_declarado' => $totalArchivos,
            'archivos_encontrados' => count($archivosRecibidos),
            'detalles' => $archivosRecibidos
        ]);

        // Modificar la validación para incluir múltiples archivos
        $validationRules = [
            'Paciente_ID' => 'required|exists:paciente,Paciente_ID',
            'Tipo_Consulta_ID' => 'required|exists:tipo_consulta,Tipo_Consulta_ID',
            'Documento_ID' => 'required|exists:documento,Documento_ID',
            'Pago_ID' => 'required|exists:pago,Pago_ID',
            'Divisa_ID' => 'required|exists:divisas,Divisa_ID',

            // Campos numéricos según tu migración (decimal 5,2)
            'peso' => 'nullable|numeric|between:0,999.99',
            'talla' => 'nullable|string',
            'cintura' => 'nullable|numeric|between:0,999.99',
            'cadera' => 'nullable|numeric|between:0,999.99',
            'gc' => 'nullable|numeric|between:0,999.99',
            'mm' => 'nullable|numeric|between:0,999.99',
            'em' => 'nullable|numeric|between:0,999.99',
            'altura' => 'nullable|numeric|between:0,999.99',
            'proteina' => 'nullable|numeric|between:0,999.99',
            'ec'=> 'nullable|numeric|between:0,999.99',
            'me' => 'nullable|numeric|between:0,999.99',
            'gv' => 'nullable|numeric|between:0,999.99',
            'pg' => 'nullable|numeric|between:0,999.99',
            'gs' => 'nullable|numeric|between:0,999.99',
            'meq' => 'nullable|numeric|between:0,999.99',
            'bmr' => 'nullable|numeric|min:0|max:99999.99',
            'ac' => 'nullable|numeric|between:0,999.99',
            'imc' => 'nullable|numeric|between:0,999.99',

            // Campos de texto
            'detalles_diagnostico' => 'nullable|string',
            'resultados_evaluacion' => 'nullable|string',
            'analisis_nutricional' => 'nullable|string',
            'objetivo_descripcion' => 'nullable|string',

            // Fecha y archivos
            'proxima_consulta' => 'nullable|date_format:Y-m-d H:i:s',
            'nombre_consultorio' => 'nullable|string',
            'direccion_consultorio'=>'nullable|string',
            'total_archivos' => 'nullable|integer|min:0|max:10',
            'estado_proximaConsulta' => 'nullable|intenger|min:0|max:10',
        ];

        // Agregar reglas de validación dinámicas para cada archivo
        for ($i = 0; $i < $totalArchivos; $i++) {
            $fileInputName = "plan_nutricional_path_{$i}";
            $validationRules[$fileInputName] = 'nullable|file|mimes:pdf,doc,docx|max:15500'; // Máximo 15MB
        }

        $validator = Validator::make($request->all(), $validationRules, [
            'Paciente_ID.exists' => 'El paciente seleccionado no existe',
            'Tipo_Consulta_ID.exists' => 'El tipo de consulta seleccionado no existe',
            'Documento_ID.exists' => 'El documento seleccionado no existe',
            'Pago_ID.exists' => 'El tipo de pago seleccionado no existe',
            'Divisa_ID.exists' => 'La divisa seleccionada no existe',
            'numeric' => 'El campo :attribute debe ser un número',
            'between' => 'El campo :attribute debe estar entre :min y :max',
            'mimes' => 'El archivo debe ser PDF, DOC o DOCX',
            'max' => 'El archivo no debe exceder 15MB'
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida en guardarConsulta:', $validator->errors()->toArray());
            return response()->json([
                'status' => 'error',
                'message' => 'Datos inválidos',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Obtener datos del paciente para la consulta
            $paciente = Paciente::where('Paciente_ID', $request->Paciente_ID)->first();
            if (!$paciente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            // Crear nuevo registro de consulta primero para obtener el ID
            $consulta = new Consulta();
            $consulta->Paciente_ID = $request->Paciente_ID;
            $consulta->Tipo_Consulta_ID = $request->Tipo_Consulta_ID;
            $consulta->user_id = $user->id;
            $consulta->Documento_ID = $request->Documento_ID;
            $consulta->Pago_ID = $request->Pago_ID;
            $consulta->Divisa_ID = $request->Divisa_ID;

            // Datos del paciente
            $consulta->nombre_paciente = $paciente->nombre;
            $consulta->apellidos = $paciente->apellidos;
            $consulta->email = $paciente->email;
            $consulta->telefono = $paciente->telefono;
            $consulta->genero = $paciente->genero;
            $consulta->usuario = $paciente->usuario;
            $consulta->enfermedad = $paciente->enfermedad;
            $consulta->localidad = $paciente->localidad;
            $consulta->ciudad = $paciente->ciudad;
            $consulta->edad = $paciente->edad;
            $consulta->fecha_nacimiento = $paciente->fecha_nacimiento;
            $consulta->nombre_nutriologo = $user->nombre . ' ' . $user->apellidos;

            // Datos adicionales de consulta
            $consulta->peso = $request->peso;
            $consulta->talla = $this->normalizarTalla($request->talla);
            $consulta->cintura = $request->cintura;
            $consulta->cadera = $request->cadera;
            $consulta->gc = $request->gc;
            $consulta->mm = $request->mm;
            $consulta->em = $request->em;
            $consulta->altura = $request->altura;
            $consulta->proteina = $request->proteina;
            $consulta->ec = $request->ec;
            $consulta->me = $request->me;
            $consulta->gv = $request->gv;
            $consulta->pg = $request->pg;
            $consulta->gs = $request->gs;
            $consulta->meq = $request->meq;
            $consulta->bmr = $request->bmr;
            $consulta->ac = $request->ac;
            $consulta->imc = $request->imc;

            // Asignar datos de CKEditor
            $consulta->detalles_diagnostico = $request->detalles_diagnostico;
            $consulta->resultados_evaluacion = $request->resultados_evaluacion;
            $consulta->analisis_nutricional = $request->analisis_nutricional;
            $consulta->objetivo_descripcion = $request->objetivo_descripcion;

            // Nuevo campo: próxima consulta
            if ($request->proxima_consulta) {
                $consulta->proxima_consulta = $request->proxima_consulta;
            }
            $consulta->nombre_consultorio = $request->nombre_consultorio;
            $consulta->direccion_consultorio = $request->direccion_consultorio;
            // Otros datos necesarios
            $consulta->fecha_creacion = now();
            $consulta->estado = true;
            $consulta->estado_proximaConsulta = 3; //0:Cancelado, 1:En Progreso, 2: Proxima Consulta, 3: Realizado, 4:En Espera

            // Calcular total del pago (obteniendo el precio del tipo de consulta)
            $tipoConsulta = Tipo_Consulta::find($request->Tipo_Consulta_ID);
            $divisa = Divisas::find($request->Divisa_ID);

            if ($tipoConsulta && $divisa) {
                $precioMXN = $tipoConsulta->Precio;
                $consulta->total_pago = $precioMXN / $divisa->tasa_cambio;
            }

            // Guardar la consulta primero para obtener su ID
            $consulta->save();

            // Ahora procesamos los archivos con el ID de consulta disponible
            $plan_nutricional_urls = [];
            $totalArchivos = (int)$request->input('total_archivos', 0);

            // Crear la estructura de directorios personalizada para este paciente y consulta
            $nombreCarpetaPaciente = Str::slug($paciente->nombre . '+' . $paciente->apellidos);
            $carpetaConsulta = 'plan_nutricional/' . $nombreCarpetaPaciente . '/' . $consulta->Consulta_ID;

            // Crear el directorio si no existe
            if (!Storage::disk('public')->exists($carpetaConsulta)) {
                Storage::disk('public')->makeDirectory($carpetaConsulta, 0755, true);
            }

            // Agregar logging para depuración
            Log::info("Total de archivos a procesar: {$totalArchivos}");

            // Usar un hash para verificar duplicados reales (basado en contenido)
            $procesadosHashes = [];

            for ($i = 0; $i < $totalArchivos; $i++) {
                $fileInputName = "plan_nutricional_path_{$i}";

                if ($request->hasFile($fileInputName)) {
                    $file = $request->file($fileInputName);

                    if (!$file->isValid()) {
                        Log::error("Archivo no válido: {$fileInputName}");
                        continue;
                    }

                    // Verificar el tipo de archivo
                    $extension = strtolower($file->getClientOriginalExtension());
                    $tipoArchivo = $file->getMimeType();

                    Log::info("Procesando archivo {$i}: {$file->getClientOriginalName()} (Tipo: {$tipoArchivo}, Extensión: {$extension})");

                    // Verificar si es una extensión permitida
                    $extensionesPermitidas = ['pdf', 'doc', 'docx'];
                    if (!in_array($extension, $extensionesPermitidas)) {
                        Log::warning("Tipo de archivo no permitido: {$extension}");
                        continue;
                    }

                    // Obtener hash del archivo para identificarlo de manera única
                    $fileHash = md5_file($file->getRealPath());
                    $originalName = $file->getClientOriginalName();

                    // Verificar si este archivo ya ha sido procesado en esta petición
                    if (in_array($fileHash, $procesadosHashes)) {
                        Log::info("Archivo duplicado en esta petición, se omite: {$originalName}");
                        continue;
                    }

                    // Registrar este archivo como procesado
                    $procesadosHashes[] = $fileHash;

                    // Crear un nombre único que incluya parte del nombre original
                    $safeOriginalName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
                    $uniqueFilename = $consulta->Consulta_ID . '_' . time() . '_' . $i . '_' . $safeOriginalName . '.' . $extension;

                    // Guardar el archivo en la nueva estructura de directorios
                    try {
                        $path = $file->storeAs($carpetaConsulta, $uniqueFilename, 'public');

                        if ($path) {
                            $fileUrl = asset('storage/' . $path);
                            $plan_nutricional_urls[] = $fileUrl;
                            Log::info("Archivo guardado exitosamente: {$path} (URL: {$fileUrl})");
                        } else {
                            Log::error("Error al guardar el archivo: {$originalName}");
                        }
                    } catch (\Exception $e) {
                        Log::error("Error al guardar archivo {$originalName}: " . $e->getMessage());
                    }
                } else {
                    Log::info("No se encontró archivo para el input: {$fileInputName}");
                }
            }

            // Actualizar la consulta con las URLs de los archivos
            if (!empty($plan_nutricional_urls)) {
                $consulta->plan_nutricional_path = json_encode($plan_nutricional_urls);
                $consulta->save();
                Log::info("Consulta actualizada con " . count($plan_nutricional_urls) . " archivos");
            } else {
                Log::warning("No se guardaron archivos para esta consulta");
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Consulta guardada correctamente',
                'data' => [
                    'consulta' => $consulta,
                    'archivos_guardados' => count($plan_nutricional_urls),
                ]
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar consulta: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Error al guardar la consulta',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Formatea la fecha de próxima consulta al formato adecuado para la base de datos
     */
    private function formatearFechaConsulta($fechaStr)
    {
        try {
            // Intentar parsear la fecha desde el formato "Mayo, 16, 2025, 8:55 PM"
            // Carbon soporta parseo de fechas en español
            return Carbon::parse($fechaStr)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            Log::error('Error al formatear fecha de consulta: ' . $e->getMessage());
            // Si no se puede parsear, retornar la fecha original
            return $fechaStr;
        }
    }

    /**
     * Normaliza el valor de talla para convertir nombres a abreviaturas
     */
    private function normalizarTalla($talla)
    {
        if (!$talla) return null;

        // Convertir a minúsculas para hacer la comparación insensible a mayúsculas
        $tallaLower = strtolower(trim($talla));

        // Mapeo de nombres de tallas a abreviaturas
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

        // Verificar si la talla está en el mapeo
        foreach ($mappingTallas as $nombre => $abreviatura) {
            if (strpos($tallaLower, $nombre) !== false) {
                return $abreviatura;
            }
        }

        // Si ya es una abreviatura común, retornarla en mayúsculas
        $abreviaturas = ['CH', 'M', 'G', 'XG', 'XCH', 'XXG'];
        $tallaUpper = strtoupper($talla);
        if (in_array($tallaUpper, $abreviaturas)) {
            return $tallaUpper;
        }

        // Si no se pudo mapear, devolver el valor original
        return $talla;
    }

    /**
     * Obtener el tipo de unidad para la talla según el valor ingresado
     */
    public function obtenerUnidadTalla(Request $request)
    {
        $talla = $request->input('talla');
        $unidad = 'M'; // Valor por defecto

        if (!$talla) {
            return response()->json(['unidad' => $unidad]);
        }

        $tallaLower = strtolower(trim($talla));

        // Determinar la unidad basada en el valor de talla
        $abreviaturas = ['CH', 'M', 'G', 'XG', 'XCH', 'XXG', 'ch', 'm', 'g', 'xg', 'xch', 'xxg'];

        // Verificar si es un término de talla en lugar de una medida numérica
        foreach ($abreviaturas as $abreviatura) {
            if (strpos($tallaLower, strtolower($abreviatura)) !== false) {
                return response()->json(['unidad' => strtoupper($abreviatura)]);
            }
        }

        // Verificar referencias a tamaños
        $terminos = [
            'chico' => 'CH',
            'chica' => 'CH',
            'pequeño' => 'CH',
            'pequeña' => 'CH',
            'mediano' => 'M',
            'mediana' => 'M',
            'medio' => 'M',
            'media' => 'M',
            'grande' => 'G',
            'extra grande' => 'XG',
            'extragrande' => 'XG',
            'extra chico' => 'XCH',
            'extrachico' => 'XCH',
        ];

        foreach ($terminos as $termino => $abreviatura) {
            if (strpos($tallaLower, $termino) !== false) {
                return response()->json(['unidad' => $abreviatura]);
            }
        }

        // Si no se encuentra ninguna coincidencia, devolver M como valor por defecto
        return response()->json(['unidad' => $unidad]);
    }
}
