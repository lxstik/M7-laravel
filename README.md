API de Gestión de Mascotas
--------------------------

Información general
-------------------
Esta API permite gestionar usuarios y mascotas. Los usuarios pueden registrar y administrar sus propias mascotas, mientras que los administradores tienen acceso a la gestión de todos los usuarios y mascotas. La autenticación se realiza mediante tokens.

Autenticación
-------------
Para acceder a los endpoints protegidos es necesario autenticarse. Tras hacer login, debes incluir el token en la cabecera de peticiones:

Authorization: Bearer {tu_token}

Endpoints principales
---------------------

Autenticación

- Registro de usuario  
  POST /api/register  
  Body (JSON):
  {
    "name": "Nombre Usuario",
    "email": "usuario@email.com",
    "password": "contraseña",
    "password_confirmation": "contraseña"
  }

- Login  
  POST /api/login  
  Body (JSON):
  {
    "email": "usuario@email.com",
    "password": "contraseña"
  }

- Logout  
  POST /api/logout  
  Requiere autenticación con token

Gestión de mascotas

- Ver mis mascotas  
  GET /api/pets  
  Requiere autenticación

- Crear nueva mascota 
  POST /api/pets  
  Body (JSON):
  {
    "nombre": "Rufus",
    "imagen": "https://Perro.jpg",
    "tipo": "Perro"
  }

- Ver mascota por id  
  GET /api/pets/{id}  
  Solo el dueño o un usuario con rol de admin pueden ver la mascota

- Editar mascota (completo)
  PUT /api/pets/{id}  
  Body (JSON):
  {
    "nombre": "Nuevo nombre",
    "imagen": "https://ejemplo.com/nueva.jpg",
    "tipo": "Nuevo tipo"
  }

- Editar mascota (parcial)  
  PATCH /api/pets/{id}  
  Body (JSON):
  {
    "nombre": "Nombre cambiado"
  }

- Eliminar mascota  
  DELETE /api/pets/{id}  
  Solo puedes eliminar tus propias mascotas

Gestión de usuarios (solo admin)

- Ver mascotas de un usuario  
  GET /api/users/{id}/pets

- Ver todos los usuarios  
  GET /api/users

- Ver usuario específico  
  GET /api/users/{id}

- Editar usuario  
  PUT /api/users/{id}  
  Body (JSON):
  {
    "name": "Nuevo nombre",
    "email": "nuevo@email.com",
    "role": "admin"
  }

- Eliminar usuario  
  DELETE /api/users/{id}

Errores comunes
---------------

- 422: error de validación en los datos enviados
- 401: token no válido, expirado o no enviado
- 403: no tienes permisos para realizar esta acción

Notas
-----

- Los usuarios solo pueden ver y modificar sus propias mascotas, excepto los administradores
- Existen dos roles: user y admin 
- Los tokens tienen duración limitada
- Cada mascota está vinculada a un usuario mediante el campo user_id


Credenciales de Pruebas
-----------------------

admin: 
 - "email": "egorrfal32@gmail.com",
 - "password": "140783"

user:
 - "email": "falyehor@fpllefia.com",
 - "password": "1407831h"


