public function subirPlanNutricional(Request $request)
    {
        // Obtener el usuario autenticado usando el remember_token
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Debug: registrar datos recibidos completos
        Log::info('Datos recibidos en subirPlanNutricional:', $request->all());

        // Validar la petición
        $validator = Validator::make($request->all(), [
            'Paciente_ID' => 'required|exists:paciente,Paciente_ID',
            'archivos.*' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB máximo
        ], [
            'Paciente_ID.exists' => 'El paciente seleccionado no existe',
            'archivos.*.required' => 'Debe seleccionar al menos un archivo',
            'archivos.*.file' => 'El archivo no es válido',
            'archivos.*.mimes' => 'Solo se permiten archivos PDF y Word (.pdf, .doc, .docx)',
            'archivos.*.max' => 'El tamaño máximo del archivo es 10MB'
        ]);

        if ($validator->fails()) {
            Log::error('Validación fallida en subirPlanNutricional:', $validator->errors()->toArray());
            return response()->json([
                'status' => 'error',
                'message' => 'Validación fallida',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Verificar si se enviaron archivos
            if (!$request->hasFile('archivos')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No se han enviado archivos'
                ], 422);
            }

            // Debug: verificar los archivos recibidos
            Log::info('Archivos recibidos:', [
                'cantidad' => count($request->file('archivos')),
                'nombres' => array_map(function ($file) {
                    return $file->getClientOriginalName();
                }, $request->file('archivos'))
            ]);

            // Obtener datos del paciente
            $paciente = Paciente::find($request->Paciente_ID);
            if (!$paciente) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Paciente no encontrado'
                ], 404);
            }

            // Crear estructura de carpetas
            $carpetaPaciente = str_replace(' ', '_', $paciente->nombre . '_' . $paciente->apellidos);
            $fechaActual = now()->format('Y-m-d');

            $rutaBase = "plan_nutricional/{$carpetaPaciente}/{$fechaActual}";

            // Asegurarse de que el directorio existe
            Storage::disk('public')->makeDirectory($rutaBase);

            // Verificar que el directorio se haya creado correctamente
            if (!Storage::disk('public')->exists($rutaBase)) {
                Storage::disk('public')->makeDirectory($rutaBase, 0755, true);
            }

            Log::info("Directorio creado correctamente: {$rutaBase}");

            $rutasArchivos = [];

            // Procesar cada archivo
            foreach ($request->file('archivos') as $archivo) {
                // Generar nombre único para evitar colisiones
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombreArchivo = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_\.]/', '', $nombreOriginal);

                // Debug: información del archivo
                Log::info("Procesando archivo:", [
                    'nombre_original' => $nombreOriginal,
                    'nombre_sanitizado' => $nombreArchivo,
                    'tamaño' => $archivo->getSize(),
                    'ruta_destino' => "{$rutaBase}/{$nombreArchivo}"
                ]);

                // Guardar el archivo en la ruta especificada
                $ruta = $archivo->storeAs($rutaBase, $nombreArchivo, 'public');

                // Verificar si el archivo se guardó correctamente
                if (!Storage::disk('public')->exists($ruta)) {
                    Log::error("Error al guardar el archivo {$nombreArchivo}");
                    throw new \Exception("Error al guardar el archivo {$nombreArchivo}");
                }

                Log::info("Archivo guardado correctamente: {$ruta}");

                // Añadir la ruta completa a la lista (incluyendo /storage/ para acceso web)
                $rutasArchivos[] = "/storage/{$ruta}";
            }

            // Combinar todas las rutas en una cadena separada por comas
            $rutasCombinadas = implode(',', $rutasArchivos);

            Log::info("Rutas combinadas de archivos: {$rutasCombinadas}");

            // Devolver las rutas de los archivos guardados
            return response()->json([
                'status' => 'success',
                'message' => 'Archivos subidos correctamente',
                'rutas' => $rutasArchivos,
                'ruta_combinada' => $rutasCombinadas
            ]);
        } catch (\Exception $e) {
            Log::error('Error al subir archivos: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error al procesar los archivos',
                'details' => $e->getMessage()
            ], 500);
        }
    }
