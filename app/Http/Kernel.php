<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * El stack global de middleware de la aplicación.
     *
     * Estos middleware se ejecutan durante cada solicitud a tu aplicación.
     *
     * @var array<int, class-string|string>
     * 
     * @group Global Middleware
     */
    protected $middleware = [
        // Middleware para gestionar proxies de confianza (especialmente en entornos con proxies inversos)
        \App\Http\Middleware\TrustProxies::class,

        // Middleware para manejar solicitudes CORS (Cross-Origin Resource Sharing)
        \Illuminate\Http\Middleware\HandleCors::class,

        // Middleware que previene solicitudes mientras la aplicación esté en mantenimiento
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,

        // Middleware para validar el tamaño máximo permitido en las solicitudes POST
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // Middleware para recortar los valores de las cadenas de texto en las solicitudes
        \App\Http\Middleware\TrimStrings::class,

        // Middleware que convierte cadenas vacías en nulas
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * Los grupos de middleware para las rutas de la aplicación.
     *
     * Estos grupos permiten asignar middleware a diferentes rutas de la aplicación.
     *
     * @var array<string, array<int, class-string|string>>
     * 
     * @group Middleware Groups
     */
    protected $middlewareGroups = [
        // Middleware aplicados a todas las rutas web
        'web' => [
            // Middleware para cifrar las cookies
            \App\Http\Middleware\EncryptCookies::class,
            
            // Middleware que agrega cookies a la respuesta
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // Middleware que inicia la sesión de usuario
            \Illuminate\Session\Middleware\StartSession::class,

            // Middleware para compartir los errores de la sesión
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // Middleware que verifica los tokens CSRF (protección contra ataques CSRF)
            \App\Http\Middleware\VerifyCsrfToken::class,

            // Middleware para sustituir los enlaces en las rutas
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        // Middleware aplicados a las rutas de la API
        'api' => [
            // Middleware para limitar la tasa de solicitudes a la API
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',

            // Middleware para sustituir los enlaces en las rutas
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * Los alias de middleware para la aplicación.
     *
     * Estos alias permiten usar nombres más cortos en lugar de clases completas de middleware.
     * Facilitando su asignación a rutas y grupos de middleware.
     *
     * @var array<string, class-string|string>
     * 
     * @group Middleware Aliases
     */
    protected $middlewareAliases = [
        // Alias para el middleware de autenticación (requiere que el usuario esté autenticado)
        'auth' => \App\Http\Middleware\Authenticate::class,

        // Alias para la autenticación con autenticación básica HTTP
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,

        // Alias para la autenticación de sesión
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,

        // Alias para configurar los encabezados de caché
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,

        // Alias para autorizar a los usuarios basados en sus permisos
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // Alias para redirigir a los usuarios autenticados a otra página
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,

        // Alias para requerir una confirmación de contraseña
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,

        // Alias para manejar solicitudes precognitivas (sincronización de datos anticipada)
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,

        // Alias para verificar la firma en las URLs
        'signed' => \App\Http\Middleware\ValidateSignature::class,

        // Alias para limitar la tasa de solicitudes
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // Alias para asegurar que el correo electrónico del usuario esté verificado
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Alias para autenticar con JWT (JSON Web Token)
        'auth.jwt' => \PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate::class,
    ];
}
