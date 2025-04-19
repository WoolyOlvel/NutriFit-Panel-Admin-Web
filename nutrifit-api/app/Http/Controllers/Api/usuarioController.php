<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usuarioController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $usuarios = Usuario::all();

        $data = [
            'usuarios' => $usuarios,
            'status' => '200',
        ];

        // Return the users as a JSON response
        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:usuarios',
            'username' => 'required|string|max:255|unique:usuarios',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ]);
        if ($validator->fails()) {

            $data = [
                'message' => 'Error en la validacion de datos',
                'errors' => $validator->errors(),
                'status' => '400',
            ];

            return response()->json($validator->errors(), 400);
        }

        $usuario = Usuario::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
        ]);

        if(!$usuario){
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => '400',
            ];

            return response()->json($data, 500);
        }

        $data = [
            'usuario' => $usuario,
            'status' => '200',
        ];

        // Return the created user as a JSON response
        return response()->json($data, 200);

    }

    public function show($id)
    {
        // Fetch a specific user by ID from the database
        $usuario = Usuario::find($id);

        if (!$usuario) {

            $data = [
                'message' => 'Usuario no encontrado',
                'status' => '404',
            ];
            // Return a 404 response if the user is not found
            return response()->json($data, 404);


        }

        $data = [
            'usuario' => $usuario,
            'status' => '200',
        ];

        // Return the user as a JSON response
        return response()->json($data, 200);
    }

    public function destroy($id){
        // Fetch a specific user by ID from the database
        $usuario = Usuario::find($id);

        if (!$usuario) {

            $data = [
                'message' => 'Usuario no encontrado',
                'status' => '404',
            ];
            // Return a 404 response if the user is not found
            return response()->json($data, 404);
        }
        $usuario->delete();
        $data = [
            'message' => 'Usuario eliminado',
            'status' => '200',
        ];
        // Return the user as a JSON response
        return response()->json($data, 200);
    }
}
