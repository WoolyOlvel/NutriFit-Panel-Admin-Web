<?php

$token = $_COOKIE['remember_token'] ?? null;

if (!$token) {
    header("Location: ../Error403/Error403.php");
    exit();
}

// Si quieres validar contra la API (opcional pero más seguro):
$response = @file_get_contents("https://nutrifitplanner.site/api/auto-login", false, stream_context_create([
    "http" => [
        "method" => "GET",
        "header" => "remember-token: $token\r\n"
    ]
]));



if ($response === false) {
    // Falló la conexión con la API, redirige a error
    header("Location: ../Error403/Error403.php");
    exit();
}

$data = json_decode($response, true);

if (!isset($data['user'])) {
    header("Location: ../Error403/Error403.php");
    
}



session_start(); // <- MUY IMPORTANTE
$_SESSION['nombre'] = $data['user']['nombre']; // Asegúrate que "name" es el campo correcto
$primerNombre = explode(' ', $_SESSION['nombre'])[0];
$_SESSION['apellidos'] = $data['user']['apellidos']; //
$_SESSION['email'] = $data['user']['email']; //
$_SESSION['rol_id'] = $data['user']['rol_id']; // Guardamos el rol_id
$_SESSION['rol_nombre'] = $data['user']['role']['nombre']; // Accede al nombre del rol
// Si llegó aquí, el usuario está autenticado
?>