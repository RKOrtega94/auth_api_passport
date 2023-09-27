# Auth API REST - Laravel / Passport

## Descripción

Sistema básico de autenticación para Api REST con Laravel/Passport y un crud de usuarios.

Éste proyecto utiliza las librerías:

-   [Laravel Passport](https://laravel.com/docs/10.x/passport)

-   [Spatie Laravel - permission](https://spatie.be/docs/laravel-permission/v5/introduction)

### Contenido

-   [Instalación](#instalación)
-   [Seeder](#seeder)
-   [Twilio - SMS service](#twilio)
-   [Endpoints](#endpoints)
    -   [Autenticación](#autenticación)
        -   [Login](#login)
        -   [Register](#register)

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

7. Por último ejecutar `passport:install`

```bash
php artisan passport:install
```

## Seeder

Para ejecutar el `seeder` puedes utilizar los comandos artisan `php artisan db:seed` o `php artisan migrate --seed` o `php artisan migrate:fresh --seed`

Lo que llamará a los seeders creados para `Roles`, `Permisos` y `Usuarios`.

El `UserSeeder` te permitirá crear un usuario administrador, con los datos por defecto o los que se pase por consola:

```bash
Creating  admin  user
Admin  name?[Admin]: YOUR_ADMIN_NAME
Admin  email?[admin@email.com]: YOUR_ADMIN_EMAIL
Admin phone?[123456789]:  YOUR_ADMIN_PHONE
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

## Twilio

Para el envío de SMS se utiliza la API de [Twilio](https://www.twilio.com/).

Para configurar el envío de SMS debes crear una cuenta en Twilio y configurar los datos en el archivo `.env`

```bash
TWILIO_SID="INSERT YOUR TWILIO SID HERE"
TWILIO_AUTH_TOKEN="INSERT YOUR TWILIO TOKEN HERE"
TWILIO_NUMBER="INSERT YOUR TWILIO NUMBER IN [E.164] FORMAT"
```

Para instalar y configurar Twilio en Laravel puedes seguir la [documentación oficial](https://www.twilio.com/es-mx/blog/como-crear-un-portal-de-sms-con-laravel-y-twilio)

`Para solucionar el error de SSL`

# Configuración de Certificados SSL para PHP

Para resolver problemas relacionados con certificados SSL en PHP, sigue estos pasos:

1. **Descarga el Archivo PEM:**

    - Descarga el archivo de paquete de certificados desde [https://curl.haxx.se/ca/cacert.pem](https://curl.haxx.se/ca/cacert.pem).

2. **Copia al Directorio Local:**

    - Copia el archivo descargado a tu directorio local, por ejemplo, `c:\cert\cacert.pem`.

3. **Edita la Configuración de PHP:**

    - Abre el archivo `php.ini` en tu editor de texto favorito. Si no estás seguro de dónde encontrarlo, consulta la documentación para localizar `php.ini` en tu sistema.

4. **Configura la Ruta del Paquete de CA:**

    - Busca la configuración `curl.cainfo` en el archivo `php.ini`.
    - Si la línea está comentada (comienza con `;`), descoméntala eliminando el punto y coma (`;`).
    - Modifica la ruta para que apunte a la ubicación del archivo `cacert.pem` que descargaste. Por ejemplo:
        ```
        curl.cainfo=c:\cert\cacert.pem
        ```

5. **Reinicia tu Servidor Web:**
    - Después de realizar estos cambios, guarda el archivo `php.ini`.
    - Reinicia tu servidor web Apache o IIS para aplicar los cambios de configuración.

Estos pasos garantizan que PHP pueda localizar y utilizar el paquete de certificados CA (`cacert.pem`) para la verificación SSL, lo que resuelve el problema "Problema de certificado SSL: no se puede obtener el certificado del emisor local".

Asegúrate de reemplazar `c:\cert\cacert.pem` con la ruta real al archivo `cacert.pem` en tu sistema.

## Endpoints

### Autenticación

#### Login

Devuelve un token de acceso para el usuario.

```bash
POST  /api/login
```

| Parámetro | Tipo   | Descripción |
| --------- | ------ | ----------- |
| email     | string | Email       |
| password  | string | Contraseña  |

`Success Response`

```bash
{
    "status": true,
    "message": "User login successfully.",
    "data": {
        "token": "tu-token-de-autenticacion",
        "user": {
            "name": "Nombre del Usuario",
            "email": "correo@ejemplo.com"
            // Otros datos del usuario que puedes agregar
        }
    }
}
```

`Error Response`

```bash
{
    "status": false,
    "message": "Invalid login details.",
    "errors": [
        // Lista de errores
    ]
}
```

#### Register

Registra un nuevo usuario.

```bash
POST  /api/register
```

| Parámetro             | Tipo   | Descripción                |
| --------------------- | ------ | -------------------------- |
| name                  | string | Nombre                     |
| email                 | string | Email                      |
| phone                 | string | Teléfono                   |
| password              | string | Contraseña                 |
| password_confirmation | string | Confirmación de contraseña |

`Success response`

```bash
{
    "status": true,
    "message": "User register successfully.",
    "data": {
        "token": "tu-token-de-autenticacion",
        "user": {
            "name": "Nombre del Usuario",
            "email": "correo@ejemplo.com"
            // Otros datos del usuario que puedes agregar
        }
    }
}
```

`Error Response`

```bash
{
    "status": false,
    "message": "Invalid register details.",
    "errors": [
        // Lista de errores
    ]
}
```

#### Forgot password

Envía un sms con `Twilio` al usuario con un código de verificación para cambiar la contraseña.

```bash
POST  /api/forgot-password
```

| Parámetro | Tipo   | Descripción |
| --------- | ------ | ----------- |
| phone     | string | Teléfono    |

`Success response`

```bash
{
    "success": true,
    "result": "User",
    "message": "Code sent successfully to your phone +123456789"
}
```
