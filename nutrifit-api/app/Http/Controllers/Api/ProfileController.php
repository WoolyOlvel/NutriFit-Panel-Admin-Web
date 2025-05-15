<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProfileController extends Controller
{


    public function getProfileUser(Request $request, $user_id)
    {
        // Obtenemos el usuario específico por su ID
        $user = User::find($user_id);

        // Verificamos si el usuario existe
        if (!$user) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'nombre' => $user->nombre,
                'apellidos' => $user->apellidos,
                'email' => $user->email,
                'usuario' => $user->usuario
            ]
        ]);
    }

    public function updateProfile(Request $request, $user_id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user_id,
            'usuario' => 'required|string|max:255|unique:users,usuario,'.$user_id
        ]);

        $user = User::findOrFail($user_id);
        $user->update($request->only(['nombre', 'apellidos', 'email', 'usuario']));

        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $user
        ]);
    }

    public function createPaciente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telefono' => 'nullable|string|max:20',
            'genero' => 'nullable|string|max:20',
            'usuario' => 'nullable|string|max:255',
            'enfermedad' => 'nullable|string',
            'ciudad' => 'nullable|string|max:255',
            'localidad' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'fecha_nacimiento' => 'nullable|date',
            'fecha_creacion' => 'required|date'
        ]);

        // Manejar la subida de la foto
      $fotoUrl = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nombre) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('pacientes', $filename, 'public');
            $fotoUrl = asset('storage/' . $path);
        } else if ($request->has('imagen_predeterminada') && $request->imagen_predeterminada) {
            // Usar imagen predeterminada
            $fotoUrl = null;
        }

        $paciente = Paciente::create([
            'foto' => $fotoUrl,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'genero' => $request->genero,
            'usuario' => $request->usuario,
            'rol_id' => $request->rol_id ?? 2,
            'enfermedad' => $request->enfermedad,
            'status' => $request->status ?? true,
            'estado' => $request->estado ?? true,
            'ciudad' => $request->ciudad,
            'localidad' => $request->localidad,
            'edad' => $request->edad,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_creacion' => $request->fecha_creacion
        ]);

        return response()->json([
            'message' => 'Paciente creado correctamente',
            'paciente' => $paciente
        ], 201);
    }

    // En ProfileController.php, agrega:
    public function getPacienteByEmail(Request $request)
    {
        $request->validate(['email'=>'required|email']);

        try {
            $paciente = Paciente::where('email', $request->email)->first();
        } catch (\Throwable $e) {
            Log::error("Error al buscar paciente por email: ".$e->getMessage());
            return response()->json([
                'message' => 'Error interno: '.$e->getMessage()
            ], 500);
        }

        if (! $paciente) {
            return response()->json(['message'=>'Paciente no encontrado'], 404);
        }

        return response()->json(['paciente'=>$paciente], 200);
    }

    public function updatePacienteByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'foto' => 'nullable|string',
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'genero' => 'nullable|string|max:20',
            'usuario' => 'nullable|string|max:255',
            'enfermedad' => 'nullable|string',
            'ciudad' => 'nullable|string|max:255',
            'localidad' => 'nullable|string|max:255',
            'edad' => 'nullable|integer',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        $paciente = Paciente::where('email', $request->email)->firstOrFail();

        $paciente->update($request->all());

        return response()->json([
            'message' => 'Paciente actualizado correctamente',
            'paciente' => $paciente
        ]);
    }

    public function updatePacienteWithPhotoByEmail(Request $request)
    {
        try {
            Log::info('Iniciando actualización de paciente con foto', ['request' => $request->all()]);

            $request->validate([
                'email' => 'required|email',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10048',
                'nombre' => 'required|string|max:255',
                'apellidos' => 'required|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'genero' => 'nullable|string|max:20',
                'usuario' => 'nullable|string|max:255',
                'enfermedad' => 'nullable|string',
                'ciudad' => 'nullable|string|max:255',
                'localidad' => 'nullable|string|max:255',
                'edad' => 'nullable|integer',
                'fecha_nacimiento' => 'nullable|date'
            ]);

            Log::info('Validación pasada');

            $paciente = Paciente::where('email', $request->email)->firstOrFail();
            Log::info('Paciente encontrado', ['paciente_id' => $paciente->Paciente_ID]);

            // Mantener la foto actual por defecto
            $fotoUrl = $paciente->foto;

            // Manejar la nueva foto si se envió
            if ($request->hasFile('foto')) {
                Log::info('Procesando nueva imagen');

                // Eliminar la foto anterior si existe
                if ($paciente->foto) {
                    try {
                        $parsedUrl = parse_url($paciente->foto);
                        if (isset($parsedUrl['path'])) {
                            $oldPath = str_replace('/storage/', '', $parsedUrl['path']);
                            if (Storage::disk('public')->exists($oldPath)) {
                                Storage::disk('public')->delete($oldPath);
                                Log::info('Imagen anterior eliminada');
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error("Error al eliminar imagen anterior: " . $e->getMessage());
                    }
                }

                // Guardar la nueva imagen
                $foto = $request->file('foto');
                $filename = time() . '_' . Str::slug($request->nombre ?? $paciente->nombre) . '.' . $foto->getClientOriginalExtension();
                $path = $foto->storeAs('pacientes', $filename, 'public');
                $fotoUrl = asset('storage/' . $path);
                Log::info('Nueva imagen guardada', ['path' => $path]);
            }

            // Actualizar los datos
            $updateData = [
                'foto' => $fotoUrl,
                'nombre' => $request->nombre,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'genero' => $request->genero,
                'usuario' => $request->usuario,
                'enfermedad' => $request->enfermedad,
                'ciudad' => $request->ciudad,
                'localidad' => $request->localidad,
                'edad' => $request->edad,
                'fecha_nacimiento' => $request->fecha_nacimiento
            ];

            Log::info('Datos a actualizar', $updateData);

            $paciente->update($updateData);
            Log::info('Paciente actualizado exitosamente');

            return response()->json([
                'message' => 'Paciente actualizado correctamente',
                'paciente' => $paciente
            ], 200);

        } catch (\Exception $e) {
            Log::error("Error en updatePacienteWithPhotoByEmail: " . $e->getMessage());
            return response()->json([
                'message' => 'Error interno del servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
