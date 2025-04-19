<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\usuarioController;
use App\Http\Controllers\Api\appointmentController;
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


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/usuarios', [usuarioController::class, 'index']);
Route::get('/usuarios/{id}', [usuarioController::class, 'show']);
Route::post('/usuarios', [usuarioController::class, 'store']);
Route::put('/usuarios/{id}', [usuarioController::class, 'update']);
Route::patch('/usuarios/{id}', [usuarioController::class, 'updatePartial']);
Route::delete('/usuarios/{id}', [usuarioController::class, 'destroy']);


//Registro Web
Route::post('/register', [registerController::class, 'register']);

//Login Web
Route::post('/login',[loginController::class, 'login']);
//Obtiene el token
Route::get('/auto-login', [loginController::class, 'autoLogin']);
//Cierre de sesion web
Route::post('/logout', [LoginController::class, 'logout']);

//Registro Con Redes Sociales Web
Route::get('/auth/redirect/facebook', [SocialAuthController::class, 'redirectToFacebook']);
Route::get('/auth/callback/facebook', [SocialAuthController::class, 'handleFacebookCallback']);

Route::get('/auth/redirect/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('/auth/callback/google', [SocialAuthController::class, 'handleGoogleCallback']);

//Logeo Con Redes Sociales Web
Route::post('/api/social-login/google', [SocialAuthController::class, 'google']);
Route::post('/api/social-login/facebook', [SocialAuthController::class, 'facebook']);

//Utilidades
Route::get('/talla/listar', [TallaController::class, 'listar']);
Route::post('/talla/guardar_editar', [TallaController::class, 'guardar_editar']);
Route::post('/talla/mostrar', [TallaController::class, 'mostrar']);
Route::post('/talla/eliminar', [TallaController::class, 'eliminar']);

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
