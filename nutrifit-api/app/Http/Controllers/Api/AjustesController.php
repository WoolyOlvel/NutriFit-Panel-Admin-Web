<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ajustes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AjustesController extends Controller
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

    // Obtener ajustes del usuario actual
    public function getAjustes(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $ajustes = Ajustes::where('user_id', $user->id)->first();

        // Cargar relación de rol si existe
        $user->load('role');
        // Si no hay ajustes, no creamos registro, solo enviamos datos del usuario
        $userData = [
            'nombre' => $user->nombre,
            'apellidos'=>$user->apellidos,
            'email' => $user->email,
            'rol_nombre' => $user->role->nombre ?? 'Usuario'
            // Otros campos que quieras incluir
        ];

        return response()->json([
            'success' => true,
            'data' => $ajustes ? $ajustes : new \stdClass(), // Enviamos objeto vacío si no hay ajustes
            'user' => $userData
        ]);
    }

    // Guardar datos personales (primer formulario)
    public function storeDatosPersonales(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'nombre_nutriologo' => 'required|string|max:255',
            'apellido_nutriologo' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'edad' => 'nullable|integer|min:18|max:100',
            'genero' => 'nullable|string|max:50',
            'fecha_nacimiento' => 'nullable|date',
            'profesion' => 'nullable|string|max:255',
            'especialidad' => 'nullable|string|max:255',
            'universidad' => 'nullable|string|max:255',
            'displomados' => 'nullable|string',
            'especializacion' => 'nullable|string|max:255',
            'descripcion_especialziacion' => 'nullable|string',
            'pacientes_tratados' => 'nullable|integer',
            'horario_antencion' => 'nullable|string',
            'descripcion_nutriologo' => 'nullable|string',
            'ciudad' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'modalidad' => 'nullable|string|max:255',
            'disponibilidad' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Agregar rol_id, status y email por defecto a los datos validados
            $validatedData = $validator->validated();
            $validatedData['rol_id'] = 1;
            $validatedData['status'] = 1;
            // Añadir email si no está presente y el usuario tiene email
            if ($user->email) {
                $validatedData['email'] = $user->email;
            }

            $ajustes = Ajustes::updateOrCreate(
                ['user_id' => $user->id],
                $validatedData
            );

            return response()->json([
                'success' => true,
                'message' => 'Datos personales guardados correctamente',
                'data' => $ajustes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar datos personales: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar los datos personales: ' . $e->getMessage()
            ], 500);
        }
    }

    // Guardar experiencia (segundo formulario)
    public function storeExperiencia(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'experiencia' => 'nullable|string',
            'enfermedades_tratadas' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Recuperar registro existente o establecer valores por defecto
            $existingAjustes = Ajustes::where('user_id', $user->id)->first();

            if ($existingAjustes) {
                // Actualizar solo los campos validados en el registro existente
                $existingAjustes->fill($validator->validated());
                $existingAjustes->save();
                $ajustes = $existingAjustes;
            } else {
                // Crear nuevo registro con valores por defecto
                $data = $validator->validated();
                $data['rol_id'] = 1;
                $data['status'] = 1;
                $data['email'] = $user->email;
                $data['nombre_nutriologo'] = $user->nombre ?? '';
                $data['apellido_nutriologo'] = $user->apellidos ?? '';

                $ajustes = Ajustes::create(array_merge(
                    ['user_id' => $user->id],
                    $data
                ));
            }

            return response()->json([
                'success' => true,
                'message' => 'Experiencia guardada correctamente',
                'data' => $ajustes
            ]);
        } catch (\Exception $e) {
            Log::error('Error al guardar experiencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la experiencia: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar foto de perfil
    public function updateFotoPerfil(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
               'foto' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:15120', // 5MB
        ], [
            'foto.max' => 'La foto de portada no puede exceder 15 MB.',
            'foto.mimes' => 'Formato no válido. Sólo jpeg, png, jpg o gif.',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Buscar registro existente
            $ajustes = Ajustes::where('user_id', $user->id)->first();

            if (!$ajustes) {
                // Si no existe, crear nuevo con valores por defecto
                $ajustes = new Ajustes();
                $ajustes->user_id = $user->id;
                $ajustes->rol_id = 1;
                $ajustes->status = 1;
                $ajustes->nombre_nutriologo = $user->nombre ?? '';
                $ajustes->apellido_nutriologo = $user->apellidos ?? '';
                $ajustes->email = $user->email; // Añadir email desde el usuario
                $ajustes->save();
            }

            // Eliminar foto anterior si existe
            if ($ajustes->foto && Storage::disk('public')->exists(str_replace(asset('storage/'), '', $ajustes->foto))) {
                $oldPath = str_replace(asset('storage/'), '', $ajustes->foto);
                Storage::disk('public')->delete($oldPath);
            }

            // Guardar nueva foto
            $foto = $request->file('foto');
            $filename = time() . '_' . Str::slug($user->nombre ?? 'user') . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('nutriologos', $filename, 'public');
            $fotoUrl = asset('storage/' . $path);

            $ajustes->foto = $fotoUrl;
            $ajustes->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto de perfil actualizada correctamente',
                'foto_url' => $fotoUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar foto de perfil: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto de perfil: ' . $e->getMessage()
            ], 500);
        }
    }

    // Actualizar foto de portada
    public function updateFotoPortada(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'foto_portada' => 'required|image|mimes:jpeg,png,jpg,gif|max:15120', // 5MB máximo
        ], [
            'foto_portada.max' => 'La foto de portada no puede exceder 15 MB.',
            'foto_portada.mimes' => 'Formato no válido. Sólo jpeg, png, jpg o gif.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Comprobar si el archivo existe en la solicitud
            if (!$request->hasFile('foto_portada')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se encontró ningún archivo en la solicitud'
                ], 422);
            }

            // Verificar si el archivo es válido
            if (!$request->file('foto_portada')->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo subido no es válido'
                ], 422);
            }

            // Buscar registro existente
            $ajustes = Ajustes::where('user_id', $user->id)->first();

            if (!$ajustes) {
                // Si no existe, crear nuevo con valores por defecto
                $ajustes = new Ajustes();
                $ajustes->user_id = $user->id;
                $ajustes->rol_id = 1;
                $ajustes->status = 1;
                $ajustes->nombre_nutriologo = $user->nombre ?? '';
                $ajustes->apellido_nutriologo = $user->apellidos ?? '';
                $ajustes->email = $user->email; // Añadir email desde el usuario
                $ajustes->save();
            }

            // Eliminar foto anterior si existe y si es una ruta válida
            if ($ajustes->foto_portada) {
                try {
                    $oldPath = str_replace(asset('storage/'), '', $ajustes->foto_portada);
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                } catch (\Exception $e) {
                    Log::error('Error al eliminar foto de portada anterior: ' . $e->getMessage());
                    // Continuar con el proceso aunque no se pueda eliminar la anterior
                }
            }

            // Guardar nueva foto de portada
            $foto = $request->file('foto_portada');
            $filename = time() . '_portada_' . Str::slug($user->nombre ?? 'user') . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('fotos_portadas', $filename, 'public');
            $fotoUrl = asset('storage/' . $path);

            $ajustes->foto_portada = $fotoUrl;
            $ajustes->save();

            return response()->json([
                'success' => true,
                'message' => 'Foto de portada actualizada correctamente',
                'foto_portada_url' => $fotoUrl
            ]);
        } catch (\Exception $e) {
            Log::error('Error al actualizar foto de portada: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la foto de portada: ' . $e->getMessage()
            ], 500);
        }
    }


    // Cambiar contraseña
    public function changePassword(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'La nueva contraseña es requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Actualizar la contraseña (se encripta automáticamente por Laravel)
            $user->password = bcrypt($request->password);
            $user->save();

            // Invalidar el token actual
            $user->remember_token = null;
            $user->remember_token_expires_at = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Contraseña cambiada correctamente. Serás redirigido para iniciar sesión nuevamente.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error al cambiar contraseña: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar la contraseña: ' . $e->getMessage()
            ], 500);
        }
    }

}
