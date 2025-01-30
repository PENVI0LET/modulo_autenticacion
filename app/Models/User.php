<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

/**
 * Clase User.
 * 
 * Este modelo representa a un usuario del sistema. Implementa la interfaz JWTSubject para 
 * permitir la autenticación basada en tokens JWT (JSON Web Tokens) y proporciona los 
 * métodos necesarios para trabajar con JWT en Laravel.
 * 
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * Atributos que pueden ser asignados en masa.
     *
     * Estos son los atributos que se pueden llenar de manera masiva. Se debe tener cuidado
     * al usarlos para evitar la asignación de atributos no deseados.
     *
     * @var array
     */
    protected $fillable = [
        'name',      // Nombre del usuario.
        'email',     // Correo electrónico del usuario.
        'password',  // Contraseña del usuario.
    ];

    /**
     * Atributos que deben estar ocultos para los arrays.
     *
     * Estos atributos no serán visibles cuando el modelo sea convertido a un array o JSON. 
     * Generalmente se utiliza para ocultar información sensible.
     *
     * @var array
     */
    protected $hidden = [
        'password',       // La contraseña del usuario será oculta al acceder a los datos.
        'remember_token', // Token para recordar la sesión del usuario, también oculto.
    ];

    /**
     * Obtiene el identificador único para el JWT (JSON Web Token).
     *
     * Este método es necesario para que el paquete JWT pueda identificar de manera 
     * única al usuario cuando se crea el token.
     *
     * @return mixed
     * @response 200 {
     *   "id": 1,
     *   "name": "Juan Pérez",
     *   "email": "juan@ejemplo.com"
     * }
     */
    public function getJWTIdentifier()
    {
        return $this->getKey(); // Obtiene la clave primaria del usuario.
    }

    /**
     * Obtiene las reclamaciones personalizadas para el JWT.
     * 
     * Las reclamaciones personalizadas pueden ser usadas para incluir más datos 
     * dentro del token JWT. En este caso, no se incluyen reclamaciones adicionales.
     * 
     * @return array
     * @response 200 {
     *   "data": []
     * }
     */
    public function getJWTCustomClaims()
    {
        return []; // Retorna un array vacío, sin reclamaciones adicionales.
    }

    /**
     * Recupera todos los usuarios registrados.
     *
     * Este método se puede documentar para mostrar cómo listar los usuarios.
     * 
     * @get("/users")
     * @response 200 {
     *   "data": [
     *     {
     *       "id": 1,
     *       "name": "Juan Pérez",
     *       "email": "juan@ejemplo.com"
     *     },
     *     {
     *       "id": 2,
     *       "name": "Ana Gómez",
     *       "email": "ana@ejemplo.com"
     *     }
     *   ]
     * }
     */
    public function allUsers()
    {
        return User::all(); // Obtiene todos los usuarios del sistema.
    }
}
