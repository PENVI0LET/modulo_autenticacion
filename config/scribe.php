<?php

use Knuckles\Scribe\Extracting\Strategies;

return [
    // El título HTML de la documentación generada. Si está vacío, Scribe lo inferirá de config('app.name').
    'title' => null,

    // Una breve descripción de tu API. Se incluirá en la página de documentación, la colección de Postman y la especificación OpenAPI.
    'description' => '',

    // La URL base que se mostrará en la documentación. Si está vacía, Scribe usará el valor de config('app.url') al momento de la generación.
    'base_url' => '{{ config("app.url") }}', // Tomará dinámicamente la URL base de tu app

    'routes' => [
        [
            'match' => [
                'prefixes' => ['api/*'], // Solo incluir rutas con el prefijo 'api/'
                'domains' => ['*'], // Incluir rutas de cualquier dominio
                'versions' => ['v1'], // Incluir rutas de la versión 'v1'
            ],
            'include' => [
                // 'users.index', 'POST /new', '/auth/*'
            ],
            'exclude' => [
                // 'GET /health', 'admin.*'
            ],
        ],
    ],

    // El tipo de documentación a generar
    'type' => 'static', // Generar una página HTML estática

    'theme' => 'default', // Usar el tema por defecto

    'static' => [
        'output_path' => 'public/docs', // Guardar la documentación generada en 'public/docs'
    ],

    'laravel' => [
        'add_routes' => true, // Añadir rutas automáticamente para acceder a la documentación
        'docs_url' => '/docs', // Ruta para la documentación
        'assets_directory' => null, // No cambiar la carpeta por defecto de los assets
        'middleware' => ['auth:api'], // Aplicar el middleware de autenticación a la ruta de la documentación
    ],

    'try_it_out' => [
        'enabled' => true, // Habilitar el botón "Try It Out"
        'base_url' => null, // Dejar que use la URL base de la app
        'use_csrf' => false, // No usar CSRF si no es necesario
        'csrf_url' => '/sanctum/csrf-cookie', // URL para obtener el token CSRF, si se necesita
    ],

    // Autenticación de la API
    'auth' => [
        'enabled' => true, // Habilitar autenticación
        'default' => false, // No usar autenticación por defecto en todas las rutas
        'in' => 'bearer', // Tipo de autenticación es Bearer Token
        'name' => 'Authorization', // El nombre del header para el token de autenticación
        'use_value' => env('SCRIBE_AUTH_KEY'), // Usar el valor de un token en .env para pruebas
        'placeholder' => '{YOUR_AUTH_KEY}', // Placeholder para mostrar un ejemplo de token
        'extra_info' => 'Para autenticarte, utiliza el token Bearer en el header Authorization.',
    ],

    // Personalización de la sección de introducción
    'intro_text' => <<<INTRO
Bienvenido a la documentación de nuestra API. Aquí podrás encontrar todos los endpoints disponibles, 
junto con ejemplos de uso para integrarte fácilmente con nuestra plataforma.

<aside>Para interactuar con los endpoints, puedes usar el botón "Try it out" a continuación de cada uno.</aside>
INTRO
    ,

    'example_languages' => [
        'bash', // Ejemplo en Bash
        'javascript', // Ejemplo en JavaScript
        'php', // Ejemplo en PHP
        'python', // Ejemplo en Python
    ],

    // Habilitar la generación de la colección Postman
    'postman' => [
        'enabled' => true, // Habilitar la generación de Postman collection
        'overrides' => [
            'info.version' => '1.0.0', // Puedes agregar la versión de la API aquí
        ],
    ],

    // Habilitar la generación de la especificación OpenAPI
    'openapi' => [
        'enabled' => true, // Habilitar OpenAPI spec
        'overrides' => [
            'info.version' => '1.0.0', // Puedes agregar la versión de la API aquí
        ],
    ],

    'groups' => [
        'default' => 'Endpoints', // Grupo por defecto
        'order' => [], // Ordenar los grupos si es necesario
    ],

    'logo' => 'img/logo.png', // Si tienes un logo, configúralo aquí

    'last_updated' => 'Last updated: {date:F j, Y}', // Personalizar la fecha de la última actualización

    'examples' => [
        'faker_seed' => null, // Usar un número para generar valores constantes en los ejemplos
        'models_source' => ['factoryCreate', 'factoryMake', 'databaseFirst'], // Estrategias para obtener ejemplos de los modelos
    ],

    'database_connections_to_transact' => [config('database.default')], // Configurar las conexiones de base de datos a usar en las transacciones

    'fractal' => [
        'serializer' => null, // Si usas un serializer personalizado con Fractal, configúralo aquí
    ],

    'routeMatcher' => \Knuckles\Scribe\Matching\RouteMatcher::class,
    'external' => ['html_attributes' => []], // Utilizar el matcher de rutas por defecto
];
