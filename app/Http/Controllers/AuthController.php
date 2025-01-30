<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador de autenticación de usuarios.
 * 
 * Este controlador maneja el registro, inicio de sesión, información del usuario autenticado, cierre de sesión y 
 * renovación del token JWT. Utiliza la autenticación basada en tokens JWT en combinación con Laravel.
 * 
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Registra un nuevo usuario en el sistema.
     * 
     * Este método valida los datos del usuario, crea un nuevo usuario en la base de datos y 
     * genera una respuesta con la información del usuario creado.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam name string requerido El nombre del usuario. 
     * @bodyParam email string requerido El correo electrónico del usuario. Este debe ser único. 
     * @bodyParam password string requerido La contraseña del usuario, debe estar confirmada y tener un mínimo de 8 caracteres.
     * @bodyParam password_confirmation string requerido La confirmación de la contraseña, debe coincidir con el campo de la contraseña.

     * @response 201 {
     *  "user": {
     *      "id": 1,
     *      "name": "Juan Pérez",
     *      "email": "juan@example.com",
     *      "created_at": "2025-01-28T00:00:00.000000Z",
     *      "updated_at": "2025-01-28T00:00:00.000000Z"
     *  }
     * }
     * @response 400 {
     *  "name": ["El campo name es obligatorio."],
     *  "email": ["El campo email es obligatorio."],
     *  "password": ["El campo password es obligatorio."],
     *  "password_confirmation": ["El campo password confirmation es obligatorio."]
     * }
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',                        // Nombre del usuario (obligatorio).
            'email' => 'required|email|unique:users',    // Correo electrónico (único en la base de datos).
            'password' => 'required|confirmed|min:8',    // Contraseña (confirmada y mínima longitud 8).
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json(['user' => $user], 201);
    }

    /**
     * Inicia sesión de un usuario con email y contraseña.
     * 
     * Si las credenciales son correctas, genera un token JWT para la sesión del usuario.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @bodyParam email string requerido El correo electrónico del usuario. 
     * @bodyParam password string requerido La contraseña del usuario. 
     * 
     * @response 200 {
     *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     *  "token_type": "bearer",
     *  "expires_in": 3600
     * }
     * @response 401 {
     *  "error": "Unauthorized"
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Devuelve la información del usuario autenticado.
     * 
     * Este método devuelve los datos del usuario que está autenticado con el token JWT.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @response 200 {
     *  "id": 1,
     *  "name": "Juan Pérez",
     *  "email": "juan@example.com",
     *  "created_at": "2025-01-28T00:00:00.000000Z",
     *  "updated_at": "2025-01-28T00:00:00.000000Z"
     * }
     */
    public function me()
    {
        return response()->json(Auth::user());
    }

    /**
     * Cierra la sesión del usuario autenticado.
     * 
     * Este método revoca el token JWT actual y finaliza la sesión del usuario.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @response 200 {
     *  "message": "Successfully logged out"
     * }
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Renueva el token JWT del usuario.
     * 
     * Este método genera un nuevo token JWT para el usuario autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @response 200 {
     *  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
     *  "token_type": "bearer",
     *  "expires_in": 3600
     * }
     */
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    /**
     * Responde con el token JWT generado.
     * 
     * Este método devuelve el token JWT, el tipo de token y el tiempo de expiración.
     *
     * @param string $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }
}
