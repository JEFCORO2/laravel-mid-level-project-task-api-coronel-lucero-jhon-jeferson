Proyecto: API de Gestión de Proyectos y Tareas

API RESTful desarrollada en Laravel 12 para la gestión de proyectos y tareas con las siguientes características:

Relación 1:N entre Proyectos y Tareas.

Filtros dinámicos avanzados.

Validaciones estrictas con Form Requests.

Auditoría de acciones con owen-it/laravel-auditing.

Documentación automática con L5-Swagger.

Monitoreo de requests y queries con Laravel Telescope.

Estructura limpia y profesional.

--Requisitos del sistema

PHP >= 8.1

Composer >= 2

MySQL/MariaDB

Node.js y NPM (para entorno frontend si se requiere en un futuro)

Laravel CLI (composer global require laravel/installer)

--Instalación paso a paso

Clonar el repositorio

git clone https://github.com/usuario/proyecto-postulacion.git
cd proyecto-postulacion


Instalar dependencias

composer install


Configurar variables de entorno

cp .env.example .env


Edita .env y coloca tus credenciales de base de datos:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=proyecto
DB_USERNAME=root
DB_PASSWORD=


Generar key de la aplicación

php artisan key:generate


Ejecutar migraciones y seeders

php artisan migrate --seed


Levantar el servidor

php artisan serve


API disponible en: http://127.0.0.1:8000

--Documentación con Swagger

Generar la documentación:

php artisan l5-swagger:generate


Abrir en el navegador:

http://127.0.0.1:8000/api/documentation

--Monitoreo con Telescope

Acceder al panel de Telescope:

http://127.0.0.1:8000/telescope


Desde aquí se pueden observar:

Requests HTTP recibidos.

Consultas SQL ejecutadas.

Excepciones y logs.

Jobs, eventos, notificaciones, etc.

--Probar filtros dinámicos
Listado de proyectos con filtros
GET /api/projects?status=active&name=Demo

Listado de tareas con filtros
GET /api/tasks?status=pending&priority=high&project_id=1

--Logs de Auditoría

Cada acción de crear, actualizar o eliminar un Proyecto o Tarea queda registrada en las tablas de auditoría.

Se puede consultar con un endpoint adicional:

GET /api/audits


Ejemplo de respuesta:

{
  "id": "uuid",
  "user_type": "App\\Models\\User",
  "event": "updated",
  "auditable_type": "App\\Models\\Project",
  "auditable_id": "1",
  "old_values": {"name": "Proyecto API"},
  "new_values": {"name": "Proyecto Actualizado"},
  "created_at": "2025-08-20T15:30:00"
}

--Estructura del proyecto

app/Models → Modelos (Project, Task).

app/Http/Controllers/Api → Controladores REST.

app/Http/Requests → Validaciones.

database/seeders → Seeders de proyectos y tareas.

routes/api.php → Rutas de la API.