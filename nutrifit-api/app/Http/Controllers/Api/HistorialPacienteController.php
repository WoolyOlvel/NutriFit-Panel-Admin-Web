<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Documento;
use App\Models\Divisas;
use App\Models\Pago;
use App\Models\Tipo_Consulta;
use App\Models\Paciente;
use App\Models\User;
use App\Models\Consulta;
use ZipArchive;
use Exception;

class HistorialPacienteController extends Controller
{
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

    /**
     * Obtiene los detalles completos de una consulta específica
     */
    public function getDetallesConsulta(Request $request, $consultaId)
    {
        try {
            // Validar autenticación
            $user = $this->getUserFromToken($request);
            if (!$user) {
                return response()->json(['message' => 'No autorizado'], 401);
            }

            // Obtener la consulta con todos sus detalles
            $consulta = Consulta::find($consultaId);
            if (!$consulta) {
                return response()->json(['message' => 'Consulta no encontrada'], 404);
            }

            // Obtener el paciente asociado a la consulta
            $paciente = Paciente::find($consulta->Paciente_ID);
            if (!$paciente) {
                return response()->json(['message' => 'Paciente no encontrado'], 404);
            }

            // Calcular la edad del paciente
            $edad = null;
            if ($paciente->fecha_nacimiento) {
                $fechaNacimiento = new \DateTime($paciente->fecha_nacimiento);
                $hoy = new \DateTime();
                $edad = $fechaNacimiento->diff($hoy)->y;
            }

            // Obtener la ruta de la foto del paciente
            $rutaFoto = 'user-dummy-img.jpg'; // Imagen por defecto
            if ($paciente->foto) {
                $rutaFoto = $paciente->foto;
            }

            // Obtener información del tipo de consulta
            $tipoConsulta = null;
            if ($consulta->Tipo_Consulta_ID) {
                $tipoConsultaObj = Tipo_Consulta::find($consulta->Tipo_Consulta_ID);
                if ($tipoConsultaObj) {
                    $tipoConsulta = $tipoConsultaObj->Nombre;
                }
            }

            // Obtener información del tipo de pago
            $tipoPago = null;
            if ($consulta->Pago_ID) {
                $pagoObj = Pago::find($consulta->Pago_ID);
                if ($pagoObj) {
                    $tipoPago = $pagoObj->nombre;
                }
            }

            // Obtener información de la divisa
            $divisa = null;
            if ($consulta->Divisa_ID) {
                $divisaObj = Divisas::find($consulta->Divisa_ID);
                if ($divisaObj) {
                    $divisa = $divisaObj->nombre;
                }
            }

            // Obtener los documentos relacionados con el plan alimenticio
            $documentos = [];
            if ($consulta->plan_nutricional_path) {
                // Puede ser una ruta a un archivo o varias rutas separadas por comas
                $rutas = explode(',', $consulta->plan_nutricional_path);
                foreach ($rutas as $ruta) {
                    $ruta = trim($ruta);
                    if (!empty($ruta)) {
                        // Obtener información del archivo
                        $nombreArchivo = basename($ruta);
                        $tamanoArchivo = 'N/A';

                        // Comprobar si el archivo existe y obtener su tamaño
                        if (Storage::exists($ruta)) {
                            $tamanoBytes = Storage::size($ruta);
                            $tamanoArchivo = $this->formatearTamanoArchivo($tamanoBytes);
                        }

                        $documentos[] = [
                            'nombre' => $nombreArchivo,
                            'ruta' => $ruta,
                            'tamano' => $tamanoArchivo
                        ];
                    }
                }
            }

            // Formatear fecha de próxima consulta si existe
            $proximaConsulta = null;
            if ($consulta->proxima_consulta) {
                $fecha = new \DateTime($consulta->proxima_consulta);
                $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                $proximaConsulta = $meses[$fecha->format('n') - 1] . ', ' . $fecha->format('j') . ', ' . $fecha->format('Y') . ', ' . $fecha->format('h:i A');
            }

            // Preparar la respuesta con todos los datos necesarios
            $datosConsulta = [
                'consulta_id' => $consulta->Consulta_ID,
                'paciente' => [
                    'id' => $paciente->Paciente_ID,
                    'nombre' => $paciente->nombre ?? '',
                    'apellidos' => $paciente->apellidos ?? '',
                    'foto' => $rutaFoto,
                    'edad' => $edad,
                    'genero' => $paciente->genero,
                    'fecha_nacimiento' => $paciente->fecha_nacimiento,
                    'status' => $paciente->status
                ],
                'consulta' => [
                    'fecha_creacion' => $consulta->fecha_creacion ?? $consulta->created_at,
                    'updated_at' => $consulta->updated_at ? $consulta->updated_at->diffForHumans() : 'Reciente',
                    'localidad' => $consulta->localidad ?? 'N/A',
                    'ciudad' => $consulta->ciudad ?? 'N/A',
                    'nombre_consultorio' => $consulta->nombre_consultorio ?? 'N/A',
                    'nombre_nutriologo' => $consulta->nombre_nutriologo ?? 'N/A',
                    'tipo_consulta' => $tipoConsulta ?? 'N/A',
                    'tipo_pago' => $tipoPago ?? 'N/A',
                    'divisa' => $divisa ?? 'N/A',
                    'total_pago' => $consulta->total_pago ?? 'N/A',
                    'proxima_consulta' => $proximaConsulta,
                    'estado_proximaConsulta' => $consulta->estado_proximaConsulta ?? 0
                ],
                'diagnostico' => [
                    'detalles_diagnostico' => $consulta->detalles_diagnostico ?? '',
                    'resultados_evaluacion' => $consulta->resultados_evaluacion ?? '',
                    'analisis_nutricional' => $consulta->analisis_nutricional ?? '',
                    'objetivo_descripcion' => $consulta->objetivo_descripcion ?? ''
                ],
                'antropometria' => [
                    'peso' => $consulta->peso ?? 'N/A',
                    'talla' => $consulta->talla ?? 'N/A',
                    'cintura' => $consulta->cintura ?? 'N/A',
                    'cadera' => $consulta->cadera ?? 'N/A',
                    'gc' => $consulta->gc ?? 'N/A',
                    'mm' => $consulta->mm ?? 'N/A',
                    'em' => $consulta->em ?? 'N/A',
                    'altura' => $consulta->altura ?? 'N/A'
                ],
                'enfermedad' => $consulta->enfermedad ? explode(',', $consulta->enfermedad) : [],
                'documentos' => $documentos,
                'multiple_documentos' => count($documentos) > 1
            ];

            return response()->json([
                'status' => 'success',
                'data' => $datosConsulta
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al obtener datos: ' . $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function descargarArchivo(Request $request, $consultaId)
    {
        try {
            // Validar autenticación
            $user = $this->getUserFromToken($request);
            if (!$user) {
                return response()->json(['message' => 'No autorizado'], 401);
            }

            // Obtener y decodificar la ruta
            $ruta = urldecode($request->query('ruta'));

            // Limpiar la ruta
            $ruta = str_replace(asset('storage/'), '', $ruta);
            $ruta = ltrim($ruta, '/storage');
            $ruta = ltrim($ruta, '/');

            // Verificar si la ruta existe
            if (!Storage::disk('public')->exists($ruta)) {
                Log::error("Archivo no encontrado en: " . $ruta);
                return response()->json(['message' => 'Archivo no encontrado'], 404);
            }

            // Obtener el path completo
            $fullPath = storage_path('app/public/' . $ruta);

            // Descargar el archivo
            return response()->download($fullPath, basename($ruta), [
                'Content-Type' => mime_content_type($fullPath),
            ]);

        } catch (Exception $e) {
            Log::error("Error al descargar archivo: " . $e->getMessage());
            return response()->json(['message' => 'Error al descargar archivo'], 500);
        }
    }

    public function descargarTodosDocumentos(Request $request, $consultaId)
    {
        try {
            // Validar autenticación
            $user = $this->getUserFromToken($request);
            if (!$user) {
                return response()->json(['message' => 'No autorizado'], 401);
            }

            // Obtener la consulta
            $consulta = Consulta::find($consultaId);
            if (!$consulta || !$consulta->plan_nutricional_path) {
                return response()->json(['message' => 'Documentos no encontrados'], 404);
            }

            // Verificar si es un JSON y convertirlo a array
            $planNutricional = $consulta->plan_nutricional_path;
            $rutas = [];

            if (Str::startsWith($planNutricional, '[') || Str::startsWith($planNutricional, '{')) {
                // Es probablemente un JSON
                try {
                    $rutas = json_decode($planNutricional, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $rutas = explode(',', $planNutricional);
                    }
                } catch (\Exception $e) {
                    $rutas = explode(',', $planNutricional);
                }
            } else {
                // No es JSON, tratarlo como string separado por comas
                $rutas = explode(',', $planNutricional);
            }

            // Asegurarse de que sea un array
            if (!is_array($rutas)) {
                $rutas = [$rutas];
            }

            // Filtrar rutas vacías
            $rutas = array_filter($rutas, function ($ruta) {
                return !empty(trim($ruta));
            });

            if (count($rutas) <= 0) {
                return response()->json(['message' => 'No hay documentos para descargar'], 404);
            }

            // Si solo hay un documento, descargarlo directamente
            if (count($rutas) === 1) {
                $ruta = trim($rutas[0], '"\'');

                // Determinar si es una URL o ruta relativa
                if (filter_var($ruta, FILTER_VALIDATE_URL)) {
                    $rutaStorage = str_replace(asset('storage/'), '', $ruta);
                } else {
                    $rutaStorage = $ruta;
                }

                // Verificar si es una ruta de storage
                if (Str::startsWith($rutaStorage, 'storage/')) {
                    $rutaStorage = substr($rutaStorage, 8); // Quitar 'storage/'
                }

                if (Storage::disk('public')->exists($rutaStorage)) {
                    $nombreArchivo = basename($rutaStorage);

                    return response()->download(
                        storage_path('app/public/' . $rutaStorage),
                        $nombreArchivo,
                        [
                            'Content-Type' => mime_content_type(storage_path('app/public/' . $rutaStorage)),
                            'Access-Control-Allow-Origin' => '*',
                        ]
                    );
                }

                return response()->json(['message' => 'Documento no encontrado'], 404);
            }

            // Crear un archivo ZIP temporal
            $zipFileName = 'plan_alimenticio_' . $consultaId . '.zip';
            $zipFilePath = storage_path('app/temp/' . $zipFileName);

            // Asegurarse de que el directorio existe
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            $zip = new ZipArchive();
            if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                return response()->json(['message' => 'No se pudo crear el archivo ZIP'], 500);
            }

            // Agregar cada documento al ZIP
            foreach ($rutas as $ruta) {
                if (is_string($ruta)) {
                    $ruta = trim($ruta, '"\'');
                } else {
                    continue; // Saltar si no es string
                }

                if (empty($ruta)) continue;

                // Determinar si es una URL o ruta relativa
                if (filter_var($ruta, FILTER_VALIDATE_URL)) {
                    $rutaStorage = str_replace(asset('storage/'), '', $ruta);
                } else {
                    $rutaStorage = $ruta;
                }

                // Verificar si es una ruta de storage
                if (Str::startsWith($rutaStorage, 'storage/')) {
                    $rutaStorage = substr($rutaStorage, 8); // Quitar 'storage/'
                }

                if (Storage::disk('public')->exists($rutaStorage)) {
                    $nombreArchivo = basename($rutaStorage);
                    $contenido = Storage::disk('public')->get($rutaStorage);
                    $zip->addFromString($nombreArchivo, $contenido);
                    Log::info("Archivo agregado al ZIP: {$nombreArchivo}");
                } else {
                    Log::warning("Archivo no encontrado: {$rutaStorage}");
                }
            }

            $zip->close();

            // Verificar que el ZIP se creó correctamente
            if (!file_exists($zipFilePath)) {
                return response()->json(['message' => 'Error al crear el archivo ZIP'], 500);
            }

            // Establecer CORS headers
            return response()->download($zipFilePath, $zipFileName, [
                'Content-Type' => 'application/zip',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Methods' => 'GET, POST, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With, remember-token'
            ])->deleteFileAfterSend(true);
        } catch (Exception $e) {
            Log::error("Error al descargar documentos: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error al descargar documentos: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Formatea el tamaño de un archivo para mostrar en unidades legibles
     */
    private function formatearTamanoArchivo($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
