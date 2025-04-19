<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    // Redirigir a Facebook
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    // Redirigir a Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    // Callback de Facebook
    public function handleFacebookCallback()
    {
        try {
            $socialUser = Socialite::driver('facebook')->stateless()->user();

            $fullName = $socialUser->getName();
            $parts = explode(' ', $fullName, 2);
            $nombre = $parts[0];
            $apellidos = $parts[1] ?? '';

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'usuario' => Str::slug($socialUser->getName()),
                    'password' => bcrypt(Str::random(8)),
                    'rol_id' => 1,
                    'remember_token' => Str::random(60),
                ]
            );
            $user->remember_token_expires_at = now()->addDays(30);
            $user->save();
            // Asegurarse de que tenga un remember_token
            if (!$user->remember_token) {
                $user->remember_token = Str::random(60);
                $user->save();
            }

            // Iniciar sesión con Auth
            Auth::login($user, true); // true = "recordarme"
            // Establecer la cookie de remember_token
            setcookie('remember_token', $user->remember_token, time() + (60 * 60 * 24 * 30), "/", "localhost", false, false);

            // Puedes pasar el token si así lo deseas, aunque no es necesario si usas sesión
            return redirect()->away('http://localhost/NutriFit/views/preloader/preloader.php?token=' . $user->remember_token);

            // return redirect()->away('http://localhost:8000/NutriFit/views/preloader/preloader.php?token=' . $user->remember_token); // <-- solo si lo quieres pasar
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fallo en autenticación: ' . $e->getMessage()], 500);
        }
    }

    // Callback de Google
    public function handleGoogleCallback()
    {
        try {
            $socialUser = Socialite::driver('google')->stateless()->user();

            $fullName = $socialUser->getName();
            $parts = explode(' ', $fullName, 2);
            $nombre = $parts[0];
            $apellidos = $parts[1] ?? '';

            $user = User::firstOrCreate(
                ['email' => $socialUser->getEmail()],
                [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'usuario' => Str::slug($socialUser->getName()),
                    'password' => bcrypt(Str::random(8)),
                    'rol_id' => 1,
                    'remember_token' => Str::random(60),
                ]
            );

            if (!$user->remember_token) {
                $user->remember_token = Str::random(60);
                $user->save();
            }

            Auth::login($user, true);

            return redirect()->away('http://localhost:8000/NutriFit/views/preloader/preloader.php');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fallo en autenticación: ' . $e->getMessage()], 500);
        }
    }

    public function google(Request $request)
    {
        $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->token);

        if ($payload) {
            $email = $payload['email'];
            $name = $payload['name'];

            return $this->loginOrRegisterUser($email, $name, 'google');
        }

        return response()->json(['success' => false, 'message' => 'Token inválido'], 401);
    }

    public function facebook(Request $request)
    {
        $accessToken = $request->access_token;
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v18.0',
        ]);

        try {
            $response = $fb->get('/me?fields=name,email', $accessToken);
            $user = $response->getGraphUser();
            return $this->loginOrRegisterUser($user['email'], $user['name'], 'facebook');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Token inválido'], 401);
        }
    }

    private function loginOrRegisterUser($email, $name, $provider)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Registrar al usuario
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'provider' => $provider
            ]);
        }

        $token = Str::random(60);
        $user->remember_token = $token;
        $user->save();

        return response()->json(['success' => true, 'token' => $token]);
    }
}
