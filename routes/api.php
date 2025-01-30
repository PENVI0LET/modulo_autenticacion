<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas de Autenticación
|--------------------------------------------------------------------------
|
| Estas rutas están disponibles para todos los usuarios sin necesidad de estar autenticados. 
| Se utilizan para el registro de nuevos usuarios y el inicio de sesión.
|
*/

// Ruta para registrar un nuevo usuario. 
// Esta ruta permite que cualquier usuario no autenticado se registre en el sistema.
// @bodyParam name string requerido El nombre del usuario. 
// @bodyParam email string requerido El correo electrónico del usuario, debe ser único.
// @bodyParam password string requerido La contraseña del usuario, debe estar confirmada y tener un mínimo de 8 caracteres.
// @response 201 {
//  "user": { 
//      "id": 1, 
//      "name": "Juan Pérez", 
//      "email": "juan@example.com", 
//      "created_at": "2025-01-28T00:00:00.000000Z", 
//      "updated_at": "2025-01-28T00:00:00.000000Z" 
//  }
// }
// @response 400 {
//  "name": ["El campo name es obligatorio."],
//  "email": ["El campo email es obligatorio."],
//  "password": ["El campo password es obligatorio."]
// }
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Ruta para iniciar sesión de un usuario ya existente. 
// Los usuarios no autenticados podrán acceder a esta ruta para obtener un token JWT tras ingresar sus credenciales.
// @bodyParam email string requerido El correo electrónico del usuario.
// @bodyParam password string requerido La contraseña del usuario.
// @response 200 {
//  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
//  "token_type": "bearer",
//  "expires_in": 3600
// }
// @response 401 {
//  "error": "Unauthorized"
// }
Route::post('/login', [AuthController::class, 'login'])->name('login');

/*
|--------------------------------------------------------------------------
| Rutas Protegidas
|--------------------------------------------------------------------------
|
| Las siguientes rutas requieren que el usuario esté autenticado con un token JWT válido 
| para acceder a ellas. Estas rutas permiten cerrar sesión, refrescar el token y obtener 
| la información del usuario autenticado.
|
*/

Route::middleware('auth.jwt')->group(function () {
    // Ruta para cerrar sesión (requiere token JWT válido). 
    // Esta ruta permite a los usuarios autenticados revocar su token y cerrar sesión.
    // @response 200 {
    //  "message": "Successfully logged out"
    // }
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Ruta para refrescar el token JWT (requiere token válido). 
    // Los usuarios autenticados pueden usar esta ruta para obtener un nuevo token JWT cuando el actual esté a punto de expirar.
    // @response 200 {
    //  "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...",
    //  "token_type": "bearer",
    //  "expires_in": 3600
    // }
    Route::post('/auth/refresh', [AuthController::class, 'refresh'])->name('refresh');
    
    // Ruta para obtener los datos del usuario autenticado.
    // Esta ruta permite obtener la información del usuario actual autenticado con un token JWT.
    // @response 200 {
    //  "id": 1,
    //  "name": "Juan Pérez",
    //  "email": "juan@example.com",
    //  "created_at": "2025-01-28T00:00:00.000000Z",
    //  "updated_at": "2025-01-28T00:00:00.000000Z"
    // }
    Route::get('/auth/me', [AuthController::class, 'me'])->name('me');
});
