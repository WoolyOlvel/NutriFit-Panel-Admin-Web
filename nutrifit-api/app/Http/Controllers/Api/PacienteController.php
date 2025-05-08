<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class PacienteController extends Controller
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

    // Método para listar pacientes
    public function index(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Obtenemos los pacientes relacionados con este usuario y que tengan estado activo (true)
        $pacientes = Paciente::where('user_id', $user->id)
                    ->where('estado', true)
                    ->get();

        return response()->json([
            'status' => 'success',
            'data' => $pacientes
        ]);
    }

    // Alias para index (para mantener compatibilidad con tus rutas)
    public function listar(Request $request)
    {
        return $this->index($request);
    }

    // Método combinado para guardar o editar
    public function guardar_editar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        // Determinar si es creación o actualización
        if ($request->has('Paciente_ID') && !empty($request->Paciente_ID)) {
            return $this->actualizar($request, $user);
        } else {
            return $this->crear($request, $user);
        }
    }

    // Método para mostrar un paciente
    public function mostrar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'Paciente_ID' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar el paciente asegurando que pertenezca al usuario autenticado
        // y que su estado sea activo (true)
        $paciente = Paciente::where('Paciente_ID', $request->Paciente_ID)
                       ->where('user_id', $user->id)
                       ->where('estado', true)
                       ->first();

        if (!$paciente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $paciente
        ]);
    }

    // Método para eliminar un paciente
    public function eliminar(Request $request)
    {
        $user = $this->getUserFromToken($request);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }

        $validator = Validator::make($request->all(), [
            'Paciente_ID' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Buscar el paciente asegurando que pertenezca al usuario autenticado
        $paciente = Paciente::where('Paciente_ID', $request->Paciente_ID)
                       ->where('user_id', $user->id)
                       ->where('estado', true) // Solo permitir eliminar pacientes activos
                       ->first();

        if (!$paciente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        // Eliminar la foto si existe
        if ($paciente->foto && Str::startsWith($paciente->foto, asset('storage/'))) {
            $path = str_replace(asset('storage/'), '', $paciente->foto);
            Storage::disk('public')->delete($path);
        }

        // Eliminación lógica (soft delete)
        $paciente->estado = false;
        $paciente->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Paciente eliminado correctamente'
        ]);
    }

    // Método interno para crear un paciente
    private function crear(Request $request, $user)
    {
        // Validación de los datos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:paciente,email',
            'telefono' => 'required|string|unique:paciente,telefono',
            'genero' => 'required|in:Masculino,Femenino,Otros',
            'usuario' => 'required|string|unique:paciente,usuario',
            'enfermedad' => 'nullable|string',
            'status' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'localidad' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:0|max:150',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

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

        // Crear el nuevo paciente
        $paciente = new Paciente();
        $paciente->foto = $fotoUrl;
        $paciente->nombre = $request->nombre;
        $paciente->apellidos = $request->apellidos;
        $paciente->email = $request->email;
        $paciente->telefono = $request->telefono;
        $paciente->genero = $request->genero;
        $paciente->usuario = $request->usuario;
        $paciente->rol_id = 2; // Siempre será 2 (Paciente)
        $paciente->user_id = $user->id; // El nutriólogo que lo está creando
        $paciente->enfermedad = $request->enfermedad;
        $paciente->status = $request->status;
        $paciente->estado = true; // Por defecto activo

        // Nuevos campos
        $paciente->localidad = $request->localidad;
        $paciente->ciudad = $request->ciudad;
        $paciente->edad = $request->edad;
        $paciente->fecha_nacimiento = $request->fecha_nacimiento;

        $paciente->fecha_creacion = now();
        $paciente->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Paciente registrado correctamente',
            'data' => $paciente
        ], 201);
    }

    // Método interno para actualizar un paciente
    private function actualizar(Request $request, $user)
    {
        $pacienteId = $request->Paciente_ID;

        // Buscar el paciente asegurando que pertenezca al usuario autenticado y esté activo
        $paciente = Paciente::where('Paciente_ID', $pacienteId)
                       ->where('user_id', $user->id)
                       ->where('estado', true)
                       ->first();

        if (!$paciente) {
            return response()->json([
                'status' => 'error',
                'message' => 'Paciente no encontrado'
            ], 404);
        }

        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:255',
            'apellidos' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:paciente,email,' . $pacienteId . ',Paciente_ID',
            'telefono' => 'sometimes|string|unique:paciente,telefono,' . $pacienteId . ',Paciente_ID',
            'genero' => 'sometimes|in:Masculino,Femenino,Otros',
            'usuario' => 'sometimes|string|unique:paciente,usuario,' . $pacienteId . ',Paciente_ID',
            'enfermedad' => 'nullable|string',
            'status' => 'sometimes|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'localidad' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:255',
            'edad' => 'nullable|integer|min:0|max:150',
            'fecha_nacimiento' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Manejar la actualización de la foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($paciente->foto && Str::startsWith($paciente->foto, asset('storage/'))) {
                $oldPath = str_replace(asset('storage/'), '', $paciente->foto);
                Storage::disk('public')->delete($oldPath);
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nombre ?? $paciente->nombre) . '.' . $foto->getClientOriginalExtension();
            $path = $foto->storeAs('pacientes', $filename, 'public');
            $paciente->foto = asset('storage/' . $path);
        }

        // Actualizar los demás datos
        if ($request->has('nombre')) $paciente->nombre = $request->nombre;
        if ($request->has('apellidos')) $paciente->apellidos = $request->apellidos;
        if ($request->has('email')) $paciente->email = $request->email;
        if ($request->has('telefono')) $paciente->telefono = $request->telefono;
        if ($request->has('genero')) $paciente->genero = $request->genero;
        if ($request->has('usuario')) $paciente->usuario = $request->usuario;
        if ($request->has('enfermedad')) $paciente->enfermedad = $request->enfermedad;
        if ($request->has('status')) $paciente->status = $request->status;

        // Actualizar nuevos campos
        if ($request->has('localidad')) $paciente->localidad = $request->localidad;
        if ($request->has('ciudad')) $paciente->ciudad = $request->ciudad;
        if ($request->has('edad')) $paciente->edad = $request->edad;
        if ($request->has('fecha_nacimiento')) $paciente->fecha_nacimiento = $request->fecha_nacimiento;

        $paciente->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Paciente actualizado correctamente',
            'data' => $paciente
        ]);
    }

    // Los métodos originales se mantienen para compatibilidad con las rutas RESTful
    // pero ahora llaman a los métodos correspondientes

    public function store(Request $request)
    {
        $user = $this->getUserFromToken($request);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'No autorizado'], 401);
        }
        return $this->crear($request, $user);
    }

    public function show(Request $request, $id)
    {
        $request->merge(['Paciente_ID' => $id]);
        return $this->mostrar($request);
    }

    public function update(Request $request, $id)
    {
        $request->merge(['Paciente_ID' => $id]);
        return $this->guardar_editar($request);
    }

    public function destroy(Request $request, $id)
    {
        $request->merge(['Paciente_ID' => $id]);
        return $this->eliminar($request);
    }
}
