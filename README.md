# Auth API REST - Laravel / Passport

Sistema básico de autenticación para Api REST con Laravel/Passport y un crud de usuarios.

Éste proyecto utiliza las librerías:

-   [Laravel Passport](https://laravel.com/docs/10.x/passport)

-   [Spatie Laravel - permission](https://spatie.be/docs/laravel-permission/v5/introduction)

## Instalación

1. Clonar el repositorio

```bash
git  clone  https://github.com/RKOrtega94/auth_api_passport.git
```

2. Instalar dependencias

```bash
composer  install
```

3. Crear archivo .env

```bash
cp  .env.example  .env
```

4. Generar key

```bash
php  artisan  key:generate
```

5. Crear base de datos y configurar en el archivo .env

6. Ejecutar migraciones y seeders

```bash
php  artisan  migrate  --seed
```

## Seeder

Para ejecutar el `seeder` puedes utilizar los comandos artisan `php artisan db:seed` o `php artisan migrate --seed` o `php artisan migrate:fresh --seed`

Lo que llamará a los seeders creados para `Roles`, `Permisos` y `Usuarios`.

El `UserSeeder` te permitirá crear un usuario administrador, con los datos por defecto o los que se pase por consola:

```bash
Creating  admin  user
Admin  name?[Admin]: YOUR_ADMIN_NAME
Admin  email?[admin@email.com]: YOUR_ADMIN_EMAIL
Admin  password?[password]:  YOUR_ADMIN_PASSWORD


Admin  user  created  successfully.
Email:  admin@email.com
Password:  password
```

También te permitirá crear la cantidad de usuarios con `faker` que pases por argumento (por defecto 10)

```bash
Do you want to create random users? (yes/no) [no]: yes
How many users  do you want to create?: [10]:
Random users created successfully.
```
