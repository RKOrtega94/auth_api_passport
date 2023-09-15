# Auth API REST - Laravel / Passport

Sistema básico de autenticación para Api REST con Laravel/Passport y un crud de usuarios.

Éste proyecto utiliza las librerías:

-   [Laravel Passport](https://laravel.com/docs/10.x/passport)
-   [Spatie Laravel - permission](https://spatie.be/docs/laravel-permission/v5/introduction)

## Instalación

1. Clonar el repositorio

```bash
git clone https://github.com/RKOrtega94/auth_api_passport.git
```

2. Instalar dependencias

```bash
composer install
```

3. Crear archivo .env

```bash
cp .env.example .env
```

4. Generar key

```bash
php artisan key:generate
```

5. Crear base de datos y configurar en el archivo .env

6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```
