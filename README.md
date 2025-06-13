# API REST de Gestión de Tareas y Usuarios

API REST desarrollada en PHP para la gestión de tareas y usuarios para la prueba de Escuela didactica


## Requisitos Técnicos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- Extensiones PHP requeridas:
  - PDO
  - PDO_MySQL
  - mod_rewrite (Apache)

## Instalación

1. Clonar el repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd backend-api
```

2. Configurar la base de datos:
   - Crear una base de datos MySQL llamada `task_api`
   - Importar el esquema desde `database/schema.sql`

3. Configurar el servidor web:
   - Asegurarse que el DocumentRoot apunta a la carpeta `public`
   - Verificar que mod_rewrite está habilitado (Apache)

4. Configurar la conexión a la base de datos:
   - Editar `config/database.php` con las credenciales correspondientes


## Endpoints de la API

### Usuarios

#### Obtener todos los usuarios
```http
GET /users
```

#### Crear un nuevo usuario
```http
POST /users
Content-Type: application/json

{
    "name": "Cristian",
    "email": "Cristian@gmail.com"
}
```

### Tareas

#### Obtener todas las tareas
```http
GET /tasks
```

#### Crear una nueva tarea
```http
POST /tasks
Content-Type: application/json

{
    "user_id": 1,
    "title": "Pru"
}
```

#### Marcar tarea como completada
```http
PUT /tasks/{id}
```

#### Eliminar una tarea
```http
DELETE /tasks/{id}
```

## Respuestas

Todas las respuestas son en formato JSON y siguen este formato:

```json
{
    "data": [...],     // Datos de la respuesta 
    "error": "...",    // Mensaje de error 
    "message": "..."   // Mensaje de éxito 
}
```

## Códigos de Estado HTTP

- 200: Éxito
- 201: Recurso creado
- 400: Solicitud incorrecta
- 404: Recurso no encontrado
- 405: Método no permitido
- 500: Error interno del servidor

## Pregunta Adicional:

Para mejorar el rendimiento de la API, implementaría dos soluciones prácticas:

- Agregaría un sistema de caché con Redis para las consultas más frecuentes, como la lista de usuarios y tareas. Esto es útil porque estos datos no cambian constantemente, y al guardarlos en caché por 5 minutos, evitamos consultas repetidas a la base de datos.

- Optimizaría las consultas en MySQL agregando índices en las columnas más usadas, como el email de usuarios y la relación entre tareas y usuarios. Esto haría que las búsquedas sean más rápidas, especialmente cuando la bd tenga un volumen alto