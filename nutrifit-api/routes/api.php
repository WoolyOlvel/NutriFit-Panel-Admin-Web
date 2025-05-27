<?php

use App\Http\Controllers\Api\ActualizarConsultaController;
use App\Http\Controllers\Api\AjustesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\usuarioController;
use App\Http\Controllers\Api\appointmentController;
use App\Http\Controllers\Api\CalendarioCitasController;
use App\Http\Controllers\Api\CalendarioController;
use App\Http\Controllers\Api\chatController;
use App\Http\Controllers\Api\desafioController;
use App\Http\Controllers\Api\notificationController;
use App\Http\Controllers\Api\patientController;
use App\Http\Controllers\Api\plan_listController;
//Web
use App\Http\Controllers\Api\registerController;
use App\Http\Controllers\Api\loginController;
use App\Http\Controllers\Api\SocialAuthController;

use App\Http\Controllers\Api\TallaController;
use App\Http\Controllers\Api\Sistema_Metrico;
use App\Http\Controllers\Api\medidasCorporalesController;
use App\Http\Controllers\Api\composicionCorporalController;
use App\Http\Controllers\Api\ConsultaController;
use App\Http\Controllers\Api\estaturaController;
use App\Http\Controllers\Api\divisasController;
use App\Http\Controllers\Api\HistorialNutricionalController;
use App\Http\Controllers\Api\HistorialPacienteController;
use App\Http\Controllers\Api\ListaNutriologosMovil;
use App\Http\Controllers\Api\MisPacientesController;
use App\Http\Controllers\Api\Notificaciones;
use App\Http\Controllers\Api\NotificacionesMovilController;
use App\Http\Controllers\Api\NutriDesafiosController;
use App\Http\Controllers\Api\NutriDesafiosMovilController;
use App\Http\Controllers\Api\PacienteController;
use App\Http\Controllers\Api\PlanAlimenticioController;
use App\Http\Controllers\Api\Pre_HistorialController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReservacionController as ApiReservacionController;
use App\Http\Controllers\Api\SeguimientoController;
use App\Http\Controllers\Api\TipoConsultaController;
use App\Http\Controllers\ReservacionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/usuarios', [usuarioController::class, 'index']);
Route::get('/usuarios/{id}', [usuarioController::class, 'show']);
Route::post('/usuarios', [usuarioController::class, 'store']);
Route::put('/usuarios/{id}', [usuarioController::class, 'update']);
Route::patch('/usuarios/{id}', [usuarioController::class, 'updatePartial']);
Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy']);


//Registro Web👇
Route::post('/register', [registerController::class, 'register']);

//Login Web
Route::post('/login',[loginController::class, 'login']);
//Obtiene el token
Route::get('/auto-login', [loginController::class, 'autoLogin']);
//Cierre de sesion web
Route::post('/logout', [LoginController::class, 'logout']);

//Registro Con Redes Sociales Web👇
Route::get('/auth/redirect/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/callback/facebook', [SocialAuthController::class, 'handleFacebookCallback']);

Route::get('/auth/redirect/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [SocialAuthController::class, 'handleGoogleCallback']);
//FIN Registro Con Redes Sociales Web  👆

//Logeo Con Redes Sociales Web👇
Route::post('/api/social-login/google', [SocialAuthController::class, 'google']);
Route::post('/api/social-login/facebook', [SocialAuthController::class, 'facebook']);
//FIN lOGEO CON REDES SOCIALES WEB  👆

//Utilidades👇
//Tallas
Route::get('/talla/listar', [TallaController::class, 'listar']);
Route::post('/talla/guardar_editar', [TallaController::class, 'guardar_editar']);
Route::post('/talla/mostrar', [TallaController::class, 'mostrar']);
Route::post('/talla/eliminar', [TallaController::class, 'eliminar']);
//Sistema Metrico
Route::get('/sistema_metrico/listar', [Sistema_Metrico::class, 'listar']);
Route::post('/sistema_metrico/guardar_editar', [Sistema_Metrico::class, 'guardar_editar']);
Route::post('/sistema_metrico/mostrar', [Sistema_Metrico::class, 'mostrar']);
Route::post('/sistema_metrico/eliminar', [Sistema_Metrico::class, 'eliminar']);
//Medidas Corporales
Route::get('/medidas_corporales/listar', [medidasCorporalesController::class, 'listar']);
Route::post('/medidas_corporales/guardar_editar', [medidasCorporalesController::class, 'guardar_editar']);
Route::post('/medidas_corporales/mostrar', [medidasCorporalesController::class, 'mostrar']);
Route::post('/medidas_corporales/eliminar', [medidasCorporalesController::class, 'eliminar']);
//Composición Corporal
Route::get('/composicion_corporal/listar', [composicionCorporalController::class, 'listar']);
Route::post('/composicion_corporal/guardar_editar', [composicionCorporalController::class, 'guardar_editar']);
Route::post('/composicion_corporal/mostrar', [composicionCorporalController::class, 'mostrar']);
Route::post('/composicion_corporal/eliminar', [composicionCorporalController::class, 'eliminar']);
//Estatura
Route::get('/estatura/listar', [estaturaController::class, 'listar']);
Route::post('/estatura/guardar_editar', [estaturaController::class, 'guardar_editar']);
Route::post('/estatura/mostrar', [estaturaController::class, 'mostrar']);
Route::post('/estatura/eliminar', [estaturaController::class, 'eliminar']);
//Divisas
Route::get('/divisas/listar', [divisasController::class, 'listar']);
Route::post('/divisas/guardar_editar', [divisasController::class, 'guardar_editar']);
Route::post('/divisas/mostrar', [divisasController::class, 'mostrar']);
Route::post('/divisas/eliminar', [divisasController::class, 'eliminar']);
//Fin Utilidades👆

//Pácientes 👇
//Añadir Pacientes
Route::get('/pacientes/listar', [PacienteController::class, 'index']);
Route::post('/pacientes/guardar_editar', [PacienteController::class, 'guardar_editar']);
Route::post('/pacientes/mostrar', [PacienteController::class, 'mostrar']);
Route::post('/pacientes/eliminar', [PacienteController::class, 'eliminar']);
//Lista de Pacientes
Route::get('/misPacientes/listar',[MisPacientesController::class, 'index']);
Route::post('/misPacientes/guardar_editar',[MisPacientesController::class, 'guardar_editar']);
Route::post('/misPacientes/mostrar',[MisPacientesController::class, 'mostrar']);
Route::post('/misPacientes/eliminar',[MisPacientesController::class, 'eliminar']);

//Generar Consulta Paciente

Route::get('/consulta/tipos', [ConsultaController::class, 'getTiposConsulta']);
Route::get('/consulta/documentos', [ConsultaController::class, 'getDocumentos']);
Route::get('/consulta/tipos-pago', [ConsultaController::class, 'getTiposPago']);
Route::get('/consulta/divisas', [ConsultaController::class, 'getDivisas']);

// En api.php en la carpeta routes
Route::get('/consulta/pacientes', [ConsultaController::class, 'getPacientes']);
Route::get('/consulta/pacientes/{id}', [ConsultaController::class, 'getPacienteDetalle']);
// Nueva ruta para guardar la consulta
Route::post('/consulta/guardar', [ConsultaController::class, 'guardarConsulta']);
Route::post('/consulta/unidad-talla', [ConsultaController::class, 'obtenerUnidadTalla']);

//No usar, Peligro!! ☠️❌👇
Route::post('/consulta/subir-plan-nutricional', [ConsultaController::class, 'subirPlanNutricional']);
//Fin Peligro☠️❌👆


//Pre_Historial Paciente
Route::get('/pacientes/{pacienteId}/consultas', [Pre_HistorialController::class, 'getConsultasPaciente']);

// Obtener datos de la consulta para editar (GET)
Route::get('/consulta/editar/{consultaId}', [ActualizarConsultaController::class, 'getConsulta']);

// Actualizar consulta (POST o PUT)
Route::put('/consulta/actualizar/{consultaId}', [ActualizarConsultaController::class, 'actualizarConsulta']);

Route::get('/consulta/pacientes/{pacienteId}', [ActualizarConsultaController::class, 'obtenerConsulta']);
Route::get('/consulta/obtener/{consultaId}', [ActualizarConsultaController::class, 'obtenerConsulta']);

Route::get('/consulta/{consultaId}/descargar-documentos', [HistorialPacienteController::class,'descargarDocumentos']);
Route::get('/consulta/{consultaId}/descargar-plan', [HistorialPacienteController::class,'descargarPlanHistorial']);

Route::get('/historial-paciente/consulta/{consultaId}/descargar-documentos', [HistorialPacienteController::class,'descargarTodosDocumentos']);
Route::get('/historial-paciente/consulta/{consultaId}',[HistorialPacienteController::class,'getDetallesConsulta']);
Route::get('/historial-paciente/{consultaId}/descargar-archivo', [HistorialPacienteController::class,'descargarTodosDocumentos']);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('pacientes', 'Api\PacienteController');
});

Route::middleware('auth:api')->group(function () {
    Route::apiResource('misPacientes', 'Api\misPacientesController');
});
//Fin Pacientes 👆

//Ver Citas Agendadas 👇

Route::get('/calendario/eventos', [CalendarioCitasController::class, 'getEventos']);
Route::get('/calendario/proximos-eventos', [CalendarioCitasController::class, 'getProximosEventos']);
Route::get('/calendario/evento/{id}', [CalendarioCitasController::class, 'getEventoDetalle']);

Route::post('/calendario/crear-reservacion-desde-existente', [CalendarioCitasController::class, 'crearReservacionDesdeExistente']);
Route::put('/calendario/actualizar-reservacion/{eventId}', [CalendarioCitasController::class, 'actualizarReservacion']);


Route::put('/calendario/reservaciones/{id}', [CalendarioCitasController::class, 'actualizarReservacion']);

Route::put('/reservaciones/{realId}', [CalendarioCitasController::class, 'actualizarReservacion']);

// Para consultas
Route::put('/calendario/consultas/{id}', [CalendarioCitasController::class, 'actualizarConsulta']);

// Notificaciones
    Route::get('/notificaciones', [Notificaciones::class, 'obtenerNotificaciones']);
    Route::post('/notificaciones/marcar-leida/{id}', [Notificaciones::class, 'marcarLeida']);
    Route::get('/notificaciones/contar', [Notificaciones::class, 'contarNotificaciones']);

//Ruta Prueba Reservaciones👇

Route::post('/calendario/reservaciones', [CalendarioCitasController::class, 'crearReservacion']);

//Fin Citas Agendadas 👆


//Inicio Ajustes
Route::prefix('ajustes')->group(function () {
    Route::get('/', [App\Http\Controllers\Api\AjustesController::class, 'getAjustes']);
    Route::post('/datos-personales', [App\Http\Controllers\Api\AjustesController::class, 'storeDatosPersonales']);
    Route::post('/experiencia', [App\Http\Controllers\Api\AjustesController::class, 'storeExperiencia']);
    Route::post('/foto-perfil', [App\Http\Controllers\Api\AjustesController::class, 'updateFotoPerfil']);
    Route::post('/foto-portada', [App\Http\Controllers\Api\AjustesController::class, 'updateFotoPortada']);
});

//Fin Ajustes👆

// INICIO NUTRIDESAFIOS👇



//FIN NUTRIDESAFIOS👆

// Rutas para NutriDesafios
Route::prefix('nutridesafios')->group(function () {
    Route::get('/', [NutriDesafiosController::class, 'index']);
    Route::get('/listar', [NutriDesafiosController::class, 'listar']);
    Route::post('/guardar_editar', [NutriDesafiosController::class, 'guardar_editar']);
    Route::post('/mostrar', [NutriDesafiosController::class, 'mostrar']);
    Route::post('/eliminar', [NutriDesafiosController::class, 'eliminar']);

    // Rutas RESTful estándar
    Route::post('/', [NutriDesafiosController::class, 'store']);
    Route::get('/{id}', [NutriDesafiosController::class, 'show']);
    Route::put('/{id}', [NutriDesafiosController::class, 'update']);
    Route::delete('/{id}', [NutriDesafiosController::class, 'destroy']);
});


//Movil

    Route::get('users/{user_id}/profile', [ProfileController::class, 'getProfileUser']); //Es para obtener los datos de perfil cuando esta recien registrado
    Route::put('users/{user_id}/update', [ProfileController::class, 'updateProfile']); //Actualiza el profile pero en users solo campo nombre, apellidos, email, usuario
    Route::post('pacientes/create', [ProfileController::class, 'createPaciente']);
    Route::get('pacientest/por-email', [ProfileController::class, 'getPacienteByEmail']);
    Route::get('pacientest/paciente_id', [ProfileController::class, 'getPacienteByPacienId']);

    Route::post('pacientest/duplicar-para-nutriologo', [ProfileController::class, 'duplicarPacienteParaNutriologo']);
    Route::get('pacientes/por-email-todos', [ProfileController::class, 'getPacientesPorEmail']);

    Route::put('pacientest/update-by-email', [ProfileController::class, 'updatePacienteByEmail']);
    Route::post('pacientest/update-with-photo-by-email', [ProfileController::class, 'updatePacienteWithPhotoByEmail']);

    Route::get('nutriologos', [ListaNutriologosMovil::class, 'getNutriologos']);
    Route::get('nutriologos/byId', [ListaNutriologosMovil::class, 'getNutriologoById']);
    Route::get('nutriologos/detalles/byId',[ListaNutriologosMovil::class, 'getNutriologoDetallesById']);

    Route::get('tipo_consulta', [TipoConsultaController::class, 'index']);
    Route::post('reservaciones/create', [ApiReservacionController::class, 'create']);


    Route::prefix('movil')->group(function () {
        Route::get('notificaciones/{pacienteId}', [NotificacionesMovilController::class, 'obtenerNotificaciones']);
        Route::put('notificaciones/marcar-leida/{notificacionId}/{pacienteId}', [NotificacionesMovilController::class, 'marcarLeida']);
        Route::put('notificaciones/marcar-todas-leidas/{pacienteId}', [NotificacionesMovilController::class, 'marcarTodasLeidas']);
        Route::put('notificaciones/eliminar/{pacienteId}', [NotificacionesMovilController::class, 'eliminarNotificaciones']);
        Route::get('notificaciones/contar/{pacienteId}', [NotificacionesMovilController::class, 'contarNotificaciones']);

        Route::get('reservaciones/verificar-seguimiento/{reservacionId}/{pacienteId}', [SeguimientoController::class, 'verificarSeguimiento']);

        Route::post('verificar-seguimiento', [SeguimientoController::class, 'verificarSeguimiento2']); //Este usaremos


    });

     Route::get('historial/consultas-por-paciente', [HistorialNutricionalController::class, 'getConsultasPorPaciente']);

     Route::get('historial/consultas-por-paciente2', [HistorialNutricionalController::class, 'getConsultasPorPaciente2']);

     Route::get('historial/consultas-por-paciente3', [HistorialNutricionalController::class, 'getConsultasPorPaciente3']);

     Route::get('historial/consultas-por-paciente4', [HistorialNutricionalController::class, 'getConsultasPorPaciente4']);

     Route::get('historial/consultas-por-paciente5', [HistorialNutricionalController::class, 'getConsultasPorPaciente5']);



     Route::get('historial/consultas-por-pacienteD', [HistorialNutricionalController::class, 'getGcMmPorConsulta']);



    // Obtener detalle de una consulta específica
    Route::get('historial/detalle-consulta/{consultaId}', [HistorialNutricionalController::class, 'getDetalleConsulta']);

    Route::post('consultas/paciente/ids', [HistorialNutricionalController::class, 'getConsultaIdsPorPaciente']);


    Route::post('historial/formatearFechaSegunEstado/{fecha_consulta}', [HistorialNutricionalController::class, 'calcularTiempoRestante']);

    Route::post('historial/tiempo-restante', [HistorialNutricionalController::class, 'calcularTiempoRestante']);

    // Opción 1: POST (Recomendado)
    Route::post('consulta/planes-alimenticios', [PlanAlimenticioController::class, 'getPlanesAlimenticios']);

    // Opción 2: GET con query parameters
    Route::get('consulta/planes-alimenticios', [PlanAlimenticioController::class, 'getPlanesAlimenticios']);

    Route::get('nutri-desafios', [NutriDesafiosMovilController::class, 'index']);



//Fin Movil


Route::get('/appointments', [appointmentController::class, 'index']);
Route::get('/appointments/{id}', [appointmentController::class, 'show']);
Route::post('/appointments', [appointmentController::class, 'store']);
Route::put('/appoitnments/{id}', [appointmentController::class, 'update']);
Route::patch('/appointments/{id}', [appointmentController::class, 'updatePartial']);
Route::delete('/appointments/{id}', [appointmentController::class, 'destroy']);


Route::get('/chats', [chatController::class, 'index']);
Route::get('/chats/{id}', [chatController::class, 'show']);
Route::post('/chats', [chatController::class, 'store']);
Route::put('/chats/{id}', [chatController::class, 'update']);
Route::patch('/chats/{id}', [chatController::class, 'updatePartial']);
Route::delete('/chats/{id}', [chatController::class, 'destroy']);


Route::get('/desafios', [desafioController::class, 'index']);
Route::get('/desafios/{id}', [desafioController::class, 'show']);
Route::post('/desafios', [desafioController::class, 'store']);
Route::put('/desafios/{id}', [desafioController::class, 'update']);
Route::patch('/desafios/{id}', [desafioController::class, 'updatePartial']);
Route::delete('/desafios/{id}', [desafioController::class, 'destroy']);


Route::get('/notifications', [notificationController::class, 'index']);
Route::get('/notifications/{id}', [notificationController::class, 'show']);
Route::post('/notifications', [notificationController::class, 'store']);
Route::put('/notifications/{id}', [notificationController::class, 'update']);
Route::patch('/notifications/{id}', [notificationController::class, 'updatePartial']);
Route::delete('/notifications/{id}', [notificationController::class, 'destroy']);


Route::get('/patiens', [patientController::class, 'index']);
Route::get('/patiens/{id}', [patientController::class, 'show']);
Route::post('/patiens', [patientController::class, 'store']);
Route::put('/patiens/{id}', [patientController::class, 'update']);
Route::patch('/patiens/{id}', [patientController::class, 'updatePartial']);
Route::delete('/patiens/{id}', [patientController::class, 'destroy']);


Route::get('/plan_lists', [plan_listController::class, 'index']);
Route::get('/plan_lists/{id}', [plan_listController::class, 'show']);
Route::post('/plan_lists', [plan_listController::class, 'store']);
Route::put('/plan_lists/{id}', [plan_listController::class, 'update']);
Route::patch('/plan_lists/{id}', [plan_listController::class, 'updatePartial']);
Route::delete('/plan_lists/{id}', [plan_listController::class, 'destroy']);
