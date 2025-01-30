# Módulo de Autenticación con Laravel y API

## Instalación

```bash
# Clona el repositorio
git clone https://github.com/tu-usuario/tu-proyecto.git

# Entra en el directorio del proyecto
cd tu-proyecto

# Instala las dependencias
composer install

# Configura el archivo .env
cp .env.example .env
php artisan key:generate

# Configura la base de datos en el archivo .env y luego ejecuta las migraciones
php artisan migrate

Uso
# Inicia el servidor de desarrollo
php artisan serve
