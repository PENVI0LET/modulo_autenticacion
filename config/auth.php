<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Valores predeterminados de Autenticación
    |---------------------------------------------------------------------------
    |
    | Esta opción controla el "guard" predeterminado de autenticación y las opciones
    | de restablecimiento de contraseñas para tu aplicación. Puedes cambiar estos 
    | valores según sea necesario, pero estos son ideales para la mayoría de las 
    | aplicaciones.
    |
    */

    'defaults' => [
        'guard' => 'api',  // El guard predeterminado será 'api', lo que indica que la autenticación de la API usará JWT.
        'passwords' => 'users',  // El restablecimiento de contraseñas utilizará la configuración de 'users'.
    ],

    /*
    |---------------------------------------------------------------------------
    | Guards de Autenticación
    |---------------------------------------------------------------------------
    |
    | Aquí puedes definir todos los guards de autenticación para tu aplicación. 
    | Estos guards definen cómo se autentican los usuarios en cada solicitud.
    | La configuración predeterminada usa almacenamiento en sesiones y el proveedor Eloquent de usuarios.
    |
    * @group Authentication Guards
    */

    'guards' => [
        'web' => [
            'driver' => 'session',  // Usará el driver de sesión para la autenticación en la web.
            'provider' => 'users',  // Utiliza el proveedor de usuarios 'users' para la autenticación.
        ],

        'api' => [
            'driver' => 'jwt',  // Usará JWT (JSON Web Token) para autenticar las solicitudes de la API.
            'provider' => 'users',  // Utiliza el proveedor de usuarios 'users' para la autenticación en la API.
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Proveedores de Usuarios
    |---------------------------------------------------------------------------
    |
    | Todos los drivers de autenticación requieren un proveedor de usuarios. Este define cómo
    | se obtienen los usuarios de tu base de datos u otros sistemas de almacenamiento.
    |
    | En este caso, estamos utilizando el modelo Eloquent para los usuarios.
    |
    * @group User Providers
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',  // Usamos el driver Eloquent para obtener los usuarios.
            'model' => App\Models\User::class,  // El modelo Eloquent está en 'App\Models\User'.
        ],

        // También se puede usar el driver de base de datos si se quiere usar una tabla personalizada para los usuarios
        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Restablecimiento de Contraseñas
    |---------------------------------------------------------------------------
    |
    | Puedes especificar múltiples configuraciones para el restablecimiento de contraseñas si tienes 
    | más de una tabla o modelo de usuario en la aplicación.
    | También puedes personalizar el tiempo de expiración y las configuraciones de "throttle" para los tokens de restablecimiento.
    |
    * @group Password Reset Configuration
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',  // Utiliza el proveedor de usuarios 'users'.
            'table' => 'password_reset_tokens',  // Los tokens de restablecimiento se almacenan en la tabla 'password_reset_tokens'.
            'expire' => 60,  // Los tokens expiran después de 60 minutos.
            'throttle' => 60,  // Los usuarios deben esperar 60 segundos entre intentos de generar un token de restablecimiento.
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Tiempo de Espera para Confirmación de Contraseña
    |---------------------------------------------------------------------------
    |
    | Aquí puedes definir la cantidad de segundos antes de que expire la confirmación de la contraseña
    | y el usuario se vea obligado a ingresar nuevamente su contraseña en la pantalla de confirmación.
    | Por defecto, el tiempo de espera es de tres horas.
    |
    * @group Password Timeout Configuration
    */

    'password_timeout' => 10800,  // Tiempo en segundos para la confirmación de contraseña (3 horas).

];
